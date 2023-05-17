<?php

    $ids = array(

        "one_year" => "4",
        "snake_1" => "5",
        "snake_2" => "6"

    );

    require_once("db_data.php");
    

    function Check_Years($id, $years){

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
    
        $sql = 'SELECT id, register_date FROM users WHERE register_date >= DATEADD(year, -'.$years.', GETDATE()) AND id NOT IN (SELECT user_id FROM collected_achievements WHERE achievement_id = '.$id.')';
        if($result = $connection->query($sql)){

            while($row = $result->fetch_assoc()){

                $connection->query("INSERT INTO collected_achievements(user_id, achievement_id) VALUES (".$row['id'].", ".$id.")");

            }

        }

        $connection->close();

    }

    function Check_Snake($id, $points){

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        $sql = 'SELECT player_id, max_score FROM snake_scoreboard WHERE max_score >= '.$points.' AND player_id NOT IN (SELECT user_id FROM collected_achievements WHERE achievement_id = '.$id.')';
        if($result = $connection->query($sql)){

            while($row = $result->fetch_assoc()){

                $sql = 'INSERT INTO collected_achievements(user_id, achievement_id) VALUES ('.$row['player_id'].', '.$id.')';
                $connection->query($sql);

            }

        }

        $connection->close();

    }

    Check_Years($ids['one_year'], 1);
    Check_Snake($ids['snake_1'], 30);
    Check_Snake($ids['snake_2'], 70);

?>