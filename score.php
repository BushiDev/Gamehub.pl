<?php

    session_start();

    require_once("db_data.php");
    $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

    if(isset($_GET['o']) && $_GET['o'] != "" && isset($_GET['p']) && $_GET['p'] != "" && isset($_GET['g']) && $_GET['g'] != ""){

        $game = $_GET['g'];

        if($game == "snake"){

            $sql = "";
            switch($_GET['o']){

                case "get":
                    $sql = "SELECT ".$_GET['p']." FROM snake_scoreboard WHERE player_id = ".$_SESSION['user_data']['id'];
                    if($result = $connection->query($sql)){
    
                        if($row = $result->fetch_assoc()){

                            echo $row[$_GET['p']];

                        }

                    }
                    break;
                case "set":
                    $sql = "UPDATE snake_scoreboard SET ".$_GET['p']." = ".$_GET['v']." WHERE player_id = ".$_SESSION['user_data']['id'];
                    $connection->query($sql);
                    break;
            }

        }

    }else if($game == "pong"){

        $sql = "";

        switch($_GET['o']){

            case "win":
                $sql = "UPDATE pong_scoreboard SET win_count = win_count + 1 WHERE pong_scoreboard.player_id = ".$_SESSION['user_data']['id'];
                break;
            case "loose":
                $sql = "UPDATE pong_scoreboard SET loose_count = loose_count + 1 WHERE pong_scoreboard.player_id = ".$_SESSION['user_data']['id'];
                break;
        }

        $connection->query($sql);

    }

    $connection->close();

?>