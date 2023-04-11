<?php

    if(isset($_GET['p']) && $_GET['o']){

        session_start();

        switch($_GET['o']){

            case "set":

                require_once("db_data.php");
                $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

                if($connection->connect_errno == 0){

                    if($_GET['p'] == "color" || $_GET['p'] == "alternative_color"){

                        $sql = 'UPDATE users SET '.$_GET['p'].' = "#'.$_GET['v'].'" WHERE `id` = '.$_SESSION['user_data']['id'];
                        $_SESSION['user_data'][$_GET['p']] = "#".$_GET['v'];

                    }else{

                        $sql = 'UPDATE users SET '.$_GET['p'].' = "'.$_GET['v'].'" WHERE `id` = '.$_SESSION['user_data']['id'];
                        $_SESSION['user_data'][$_GET['p']] = $_GET['v'];

                    }
                    
                    echo $sql;

                    $connection->query($sql);
                    $connection->close();

                }

                break;

            case "get":

                echo $_SESSION['user_data'][$_GET['p']];
                break;

        }

    }

?>