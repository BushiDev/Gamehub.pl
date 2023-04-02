<?php

    if(isset($_GET['id'])){

        require_once("db_data.php");

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if($connection->connect_errno != 0){

            header("Location: login.php");

        }else{

            $sql = "UPDATE users SET `e-mail_confirmed` = 1 WHERE `id` = ".$_GET['id'];
            $connection->query($sql);
            header("Location: login.php");
        }

    }else{

        header("Location: login.php");

    }

?>