<?php
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

?>