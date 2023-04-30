<?php

    if(isset($_GET['o']) && isset($_GET['p'])){

        session_start();

        echo Check_Achievement($_GET['o'], $_GET['p'], $_SESSION['user_data']['id']);

    }

    function Check_Achievement($o, $p, $id){

        require_once("db_data.php");

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if($connection->connect_errno == 0){

            switch($o){

                case "get":
                    $sql = 'SELECT * FROM collected_achievements WHERE user_id = '.$id.' AND achievement_id = '.$p;
                    if($result = $connection->query($sql)){

                       return $result->num_rows != 0 ? "1" : "0";

                    }

                    break;
                case "set":
                    $sql = "INSERT INTO collected_achievements(`user_id`, `achievement_id`) VALUES (".$id.", ".$p.")";
                    $connection->query($sql);
                    return null;
                    break;
    
    
            }

            $connection->close();

        }
        
    }

?>