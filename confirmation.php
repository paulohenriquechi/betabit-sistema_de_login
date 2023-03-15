<?php
    require("db/connection.php");
    if(isset($_GET['code_confirm'])&&!empty($_GET['code_confirm'])){

        $code = clearPost($_GET['code_confirm']);

        $sql = $pdo->prepare("SELECT * FROM users WHERE confirmation_code=? LIMIT 1");
        $sql->execute(array($code));
        $user = $sql->fetch(PDO::FETCH_ASSOC);
        if($user){
            $sql = $pdo->prepare("UPDATE users SET status=? WHERE confirmation_code=?");
                $status = "confirmed";
                if($sql->execute(array($status, $code))){
                    header('location: index.php?result=ok');
                }
        }else{
            echo "<h1>Inválid confirmation code!</h1>";
        }
    }
?>