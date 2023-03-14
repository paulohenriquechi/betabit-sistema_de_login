<?php
    require("db/connection.php");

    if(isset($_POST["full_name"])&&isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["confirm_password"])){
        if(empty($_POST["full_name"])||empty($_POST["email"])||empty($_POST["password"])||empty($_POST["confirm_password"])||empty($_POST["terms"])){
            $error = "all fields are required!";
        }else{
            //getting post data
            $name = clearPost($_POST["full_name"]);
            $email = clearPost($_POST["email"]);
            $password = clearPost($_POST["password"]);
            $encrypted_password = sha1($password);
            $confirm_password = clearPost($_POST["confirm_password"]);
            $checkbox = clearPost($_POST["terms"]);

            //name validation
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $error_name = "Only letters and white space allowed";
            }

            //email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_email = "Invalid email format";
            }

            if(strlen($password)<6){
                $error_password = "Minimum 6 characters";
            }

            if($password!==$confirm_password){
                $error_confirm_password = "Passwords do not match";
            }

            if($checkbox!=="ok"){
                $error_checkbox = "Disabled";
            }

            if(!isset($error)&&!isset($error_name)&&!isset($error_email)&&!isset($error_password)&&!isset($error_confirm_password)&&!isset($error_checkbox)){
                //verifying if the user email is already registered
                $sql = $pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
                $sql->execute(array($email));
                $user = $sql->fetch();
                if(!$user){
                    $password_recover = "";
                    $token = "";
                    $status = "new";
                    $date = date("d/m/Y");
                    $sql = $pdo->prepare("INSERT INTO users VALUES (null, ?, ?, ?, ?, ?, ?, ?)");
                    if($sql->execute(array($name, $email, $encrypted_password, $password_recover, $token, $status, $date))){
                        header('location: index.php?result=ok');
                    }
                }else{
                    $error = "The user is already registered";
                }

            }

        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>
<body>
    <form method="post">
        <h1>Register</h1>
        <?php if(isset($error)){ ?>
            <div class="error animate__animated animate__headShake">
            <?php echo $error; ?>
            </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="img/card.png" alt="">
            <input <?php if(isset($error)||isset($error_name)){
                echo "class='error-input'";
            }?> type="text" placeholder="Full name" name="full_name" id=""
            <?php if(isset($_POST["full_name"])){
                echo "value='".$_POST["full_name"]."'";
            } ?> required>
            <?php if(isset($error_name)){ ?>
                <div class='error-msg'><?php echo $error_name?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/user.png" alt="">
            <input <?php if(isset($error)||isset($error_email)){
                echo "class='error-input'";
            }?> type="email" placeholder="Email" name="email" id="" required
            <?php if(isset($_POST["email"])){
                echo "value='".$_POST["email"]."'";
            } ?> required>
            <?php if(isset($error_email)){ ?>
                <div class='error-msg'><?php echo $error_email?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock.png" alt="">
            <input <?php if(isset($error)||isset($error_password)){
                echo "class='error-input'";
            }?> type="password" placeholder="New password (minimum 6 chars)" name="password" id=""
            <?php if(isset($_POST["password"])){
                echo "value='".$_POST["password"]."'";
            } ?> required>
            <?php if(isset($error_password)){ ?>
                <div class='error-msg'><?php echo $error_password?></div>
            <?php } ?>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock-open.png" alt="">
            <input <?php if(isset($error)||isset($error_confirm_password)){
                echo "class='error-input'";
            }?> type="password" placeholder="Confirm your password" name="confirm_password" id=""
            <?php if(isset($_POST["confirm_password"])){
                echo "value='".$_POST["confirm_password"]."'";
            } ?>required>
            <?php if(isset($error_confirm_password)){ ?>
                <div class='error-msg'><?php echo $error_confirm_password?></div>
            <?php } ?>
        </div>

        <div <?php if(isset($error)||isset($error_checkbox)){
                echo "class='error-input input-group'";
            }else{
                echo "class=input-group";
            }?>>
            <input type="checkbox" placeholder="Repeat your password" name="terms" id="terms" value="ok" required>
            <label for="terms">By clicking Register, you agree to our <a class="link" href="">Terms</a>, <a class="link" href="">Privacy Policy</a> and <a class="link" href="">Cookies Policy</a>.</label>
              
        </div>
        
        <button class="btn-blue" type="submit">Register</button>
        <a href="index.php">I'm already registered</a>
    </form>
</body>
</html>