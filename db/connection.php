<?php
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    //local and production
    $mode = "local";

    if($mode == "local"){
        $server = "localhost";
        $user = "root";
        $password = "";
        $database = "login";
    }
    if($mode == "production"){
        $server = "";
        $user = "";
        $password = "";
        $database = "";
    }

    try {
        $pdo = new PDO("mysql:host=$server;dbname=$database", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOEception $erro) {
            echo "Failed to connect to database!".$erro->getMessage();
    }

    function clearPost($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function auth($tokenSession){
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM users WHERE token=? LIMIT 1");
        $sql->execute(array($tokenSession));
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$user){
            return false;
        }else{
            return $user;
        }
    }


?>