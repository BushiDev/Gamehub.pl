<?php

    session_start();

    if(!isset($_SESSION['user_data'])){

        header("Location: logowanie");

    }

?>

<!DOCTYPE html>
<html lang="pl" style="--secondary-color: <?php echo $_SESSION['user_data']['color']; ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub - Ranking</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="style.css?v=345">
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

    <main class="leaderboards">

        <h1>Rankingi</h1>

        <?php
        
            require_once("db_data.php");

            $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

            if($connection->connect_errno == 0){

                $snake_max_score = 'SELECT ss.player_id, ss.max_score, u.show_name, u.avatar, u.color FROM snake_scoreboard AS ss INNER JOIN users AS u ON ss.player_id = u.id ORDER BY ss.max_score DESC LIMIT 5';

                if($result = $connection->query($snake_max_score)){

                    echo "<h2>Snake - Najwyższy wynik</h2>";

                    while($row = $result->fetch_assoc()){

                        $html = '<span class="ranking_row"><img src="images/avatars/'.$row['avatar'].'.png"> <a href="profil?name='.$row['show_name'].'" class="name" style="--secondary-color: '.$row['color'].';">'.$row['show_name'].'</a> <span class="score">'.$row['max_score'].'</span></span>';
                        echo $html;

                    }

                }

                $snake_games_count = "SELECT ss.player_id, ss.games_played, u.show_name, u.avatar, u.color FROM snake_scoreboard AS ss INNER JOIN users AS u ON ss.player_id = u.id ORDER BY ss.games_played DESC LIMIT 5";

                if($result = $connection->query($snake_games_count)){

                    echo "<h2>Snake - Ilość gier</h2>";

                    while($row = $result->fetch_assoc()){

                        $html = '<span class="ranking_row"><img src="images/avatars/'.$row['avatar'].'.png"> <a href="profil?name='.$row['show_name'].'" class="name" style="--secondary-color: '.$row['color'].';">'.$row['show_name'].'</a> <span class="score">'.$row['games_played'].'</span></span>';
                        echo $html;

                    }

                }

                $tic_tac_toe_total_games = "SELECT ttts.player_id, (ttts.win_count + ttts.loose_count + ttts.tie_count) AS total_games, u.show_name, u.avatar, u.color FROM tic_tac_toe_scoreboard AS ttts INNER JOIN users AS u ON ttts.player_id = u.id ORDER BY (ttts.win_count + ttts.loose_count + ttts.tie_count) DESC LIMIT 5";

                if($result = $connection->query($tic_tac_toe_total_games)){

                    echo "<h2>Tic Tac Toe - Ilość gier</h2>";

                    while($row = $result->fetch_assoc()){

                        $html = '<span class="ranking_row"><img src="images/avatars/'.$row['avatar'].'.png"> <a href="profil?name='.$row['show_name'].'" class="name" style="--secondary-color: '.$row['color'].';">'.$row['show_name'].'</a> <span class="score">'.$row['total_games'].'</span></span>';
                        echo $html;

                    }

                }

            }

        ?>


    </main>
    
</body>
</html>