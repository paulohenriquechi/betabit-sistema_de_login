<?php
    require('db/connection.php');

    //auth verification
    $user = auth($_SESSION['TOKEN']);
    if($user){
        echo "<h1>Welcome, ".$user['name']."</h1>";
        echo "<a href='logout.php'>Log out</a>";
    }else{
        header("location: index.php");
    }

    // $sql = $pdo->prepare("SELECT * FROM users WHERE token=? LIMIT 1");
    // $sql->execute(array($_SESSION['TOKEN']));
    // $user = $sql->fetch(PDO::FETCH_ASSOC);
    // if(!$user){
    //     header("location: index.php");
    // }else{
    //     echo "<h1>Welcome, ".$user['name']."</h1>";
    //     echo "<a href='logout.php'>Log out</a>";
    // }

?>