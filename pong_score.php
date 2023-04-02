<?php

    session_start();

    require_once("db_data.php");
    $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

    if(!isset($_GET['option']) || $_GET['option'] != ""){

        $sql = "";

        switch($_GET['option']){

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