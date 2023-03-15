<?php
    require("db/connection.php");

    if(isset($_POST['email'])&&isset($_POST['password'])&&!empty($_POST['email'])&&!empty($_POST['password'])){
        //getting data and cleaning
        $email = clearPost($_POST['email']);
        $password = clearPost($_POST['password']);
        $encrypted_password = sha1($password);

        //verifying if the user exists on db
        $sql = $pdo->prepare("SELECT * FROM users WHERE email=? AND password=? LIMIT 1");
        $sql->execute(array($email, $encrypted_password));
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        if($user){
            //verifying confirmed register
            if($user['status']=="confirmed"){
                //creating auth token
                $token = sha1(uniqid().date("d-m-Y-H-i-s"));
                //updating db w/ token
                $sql = $pdo->prepare("UPDATE users SET token=? WHERE email=? AND password=?");
                if($sql->execute(array($token, $email, $encrypted_password))){
                    //saving token on session
                    $_SESSION['TOKEN'] = $token;
                    header('location: restrict.php');
                } 
            }else{
                $error_login = "Please, confirm your registration by email";    
            }
        }else{
            $error_login = "Incorrect email or password";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <form method="post">
        <h1>Login</h1>

        <?php if(isset($_GET['result'])&&($_GET['result']=="ok")){ ?>
            <div class="success animate__animated animate__bounce">Your account has been successfully created.</div>
            <script>
                setTimeout(() => {
                    let success = document.querySelector(".success");
                    success.classList.add("hidden");
                }, 2000);
            </script>
        <?php } ?>

        <?php if(isset($error_login)){ ?>
            <div class="error animate__animated animate__headShake">
            <?php echo $error_login; ?>
            </div>
        <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="img/user.png" alt="">
            <input type="email" placeholder="Type your email" name="email" required>
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock.png" alt="">
            <input type="password" placeholder="Type your password" name="password" required>
        </div>
        
        <button class="btn-blue" type="submit">Log In</button>
        <a href="register.php">Create a new account</a>
    </form>

    
</body>
</html>