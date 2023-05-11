<?php

    session_start();

    if(!isset($_SESSION['user_data'])){

        header("Location: login.php");

    }

    require_once("db_data.php");

?>

<!DOCTYPE html>
<html lang="pl" style="--secondary-color: <?php echo $_SESSION['user_data']['color'] ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub - Twoje konto</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="style.css?v=62">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="manifest" href="manifest.json">

</head>
<body>

    <header>

        <span class="logo">

            Game<span class="logo_color">hub</span>

        </span>

    </header>

    <nav>

        <div><i class="fa-solid fa-plus" id="toggle"></i></div>

        <a href="osiagniecia" style="--counter: 4; --color: #ff0"><i class="fa-solid fa-trophy"></i></a>
        <a href="konto" style="--counter: 3; --color: #f00"><i class="fa-solid fa-user"></i></a>
        <a href="gry" style="--counter: 2; --color: #0ff"><i class="fa-solid fa-gamepad"></i></a>
        <a href="rankingi" style="--counter: 1; --color: #f0f"><i class="fa-solid fa-arrow-trend-up"></i></a>
        <a href="ustawienia" style="--counter: 0; --color: #0f0"><i class="fa-solid fa-gear"></i></a>

    </nav>

    <script>

        var toggle = document.querySelector("#toggle");
        var nav = document.querySelector("nav");

        toggle.onclick = function(){

            nav.classList.toggle("active");

        };

    </script>

    <main class="account">

        <?php 

            $html = '<img src="images/avatars/'.$_SESSION['user_data']['avatar'].'.png" id="player_avatar">';
        
            echo $html; 
        
        ?>

        <h1 id="player_welcome">Witaj <?php echo $_SESSION['user_data']['show_name']; ?>!</h1>

        <a href="wyloguj">Wyloguj</a>

        <article class="achievements">
        
            <h1>Twoje ostatnie osiągnięcia</h1>

            <?php
            
                $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

                if($connection->connect_errno == 0){

                    $sql = 'SELECT * FROM collected_achievements INNER JOIN achievements ON `collected_achievements`.`achievement_id` = `achievements`.`id` AND `collected_achievements`.`user_id` = '.$_SESSION['user_data']['id'].' ORDER BY `collected_achievements`.`id` DESC';

                    if($result = $connection->query($sql)){

                        if($result->num_rows == 0){

                            echo "<h2>Niestety nie zdobyłeś/aś jeszcze żadnych osiągięć</h2>";

                        }else if($result->num_rows >= 1 && $result->num_rows <= 4){

                            while($row = $result->fetch_assoc()){

                                $html = '<div class="achievement '.$row['level'].'"><img src="images/achievements/'.$row['achievement_id'].'.png"><div></div><span class="name">'.$row['name'].'</span><span class="description">'.$row['description'].'</span></div>';

                                echo $html;

                            }   

                        }else{

                            $i = 0;

                            while($row = $result->fetch_assoc()){

                                if($i < 3){

                                    $html = '<div class="achievement '.$row['level'].'"><img src="images/achievements/'.$row['achievement_id'].'.png"><div></div><span class="name">'.$row['name'].'</span><span class="description">'.$row['description'].'</span></div>';

                                    echo $html;

                                }

                                $i++;

                            }

                            $html = '<div class="achievement" onclick="window.location.href = `achievements.php`;"><i class="fa-solid fa-plus"></i><div></div></div>';

                            echo $html;

                        }

                    }

                }else{

                    echo "<h2>Przykro nam. Nie możemy nawiązać połączenia z serwerem</h2>";

                }
            
            ?>
        
        </article>

        <article class="scoreboards">

            <h2>Twoje statystyki</h2>
            <div id="pong_scores">

                <span>Pong</span>
                    
                <?php

                    $sql = 'SELECT * FROM pong_scoreboard WHERE player_id = '.$_SESSION['user_data']['id'];

                    if($result = $connection->query($sql)){

                        $result = $result->fetch_assoc();

                        echo "<span class='pong_score'>Rozegrane gry<br><br> ".(intval($result['win_count']) + intval($result['loose_count']))."</span>";
                        echo "<span class='pong_score'>Wygrane<br><br> ".$result['win_count']."</span>";
                        echo "<span class='pong_score'>Przegrane<br><br> ".$result['loose_count']."</span>";

                    }
                    
                ?>

            </div>  

            <div id="snake_scores">

                <span>Snake</span>
                    
                <?php

                    $sql = 'SELECT * FROM snake_scoreboard WHERE player_id = '.$_SESSION['user_data']['id'];

                    if($result = $connection->query($sql)){

                        $result = $result->fetch_assoc();

                        echo "<span class='snake_score'>Rozegrane gry<br><br> ".$result['games_played']."</span>";
                        echo "<span class='snake_score'>Najwyższy wynik<br><br> ".$result['max_score']."</span>";

                    }
                    
                ?>

            </div> 

            <div id="tic_tac_toe_scores">

                <span>Tic Tac Toe</span>
                    
                <?php

                    $sql = 'SELECT * FROM tic_tac_toe_scoreboard WHERE player_id = '.$_SESSION['user_data']['id'];

                    if($result = $connection->query($sql)){

                        $result = $result->fetch_assoc();

                        echo "<span class='tic_tac_toe_score'>Rozegrane gry<br><br> ".(intval($result['win_count']) + intval($result['loose_count']) + intval($result['tie_count']))."</span>";
                        echo "<span class='tic_tac_toe_score'>Wygrane<br><br> ".$result['win_count']."</span>";
                        echo "<span class='tic_tac_toe_score'>Przegrane<br><br> ".$result['loose_count']."</span>";
                        echo "<span class='tic_tac_toe_score'>Remisy<br><br> ".$result['tie_count']."</span>";

                    }

                    $connection->close();
                    
                ?>

            </div>           

        </article>

    </main>
    
</body>
</html>