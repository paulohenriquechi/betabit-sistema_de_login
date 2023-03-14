<?php
    require("db/connection.php");
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
    <form action="">
        <h2>Login</h2>

        <?php if(isset($_GET['result'])&&($_GET['result']=="ok")){ ?>
            <div class="success animate__animated animate__bounce">Your account has been successfully created.</div>
            <script>
                setTimeout(() => {
                    let sucess = document.querySelector(".success");
                    sucess.classList.add("hidden");
                }, 2000);
            </script>
            <?php } ?>

        <div class="input-group">
            <img class="input-icon" src="img/user.png" alt="">
            <input type="email" placeholder="Type your email" name="" id="">
        </div>

        <div class="input-group">
            <img class="input-icon" src="img/lock.png" alt="">
            <input type="password" placeholder="Type your password" name="" id="">
        </div>
        
        <button class="btn-blue" type="submit">Log In</button>
        <a href="register.php">Create a new account</a>
    </form>
</body>
</html>