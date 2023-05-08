<?php

    session_start();

    if(!isset($_SESSION['user_data'])){

        header("Location: logowanie?r=pong");

    }

?>

<!DOCTYPE html>
<html lang="pl" style="--secondary-color: <?php echo $_SESSION['user_data']['color'] ?>; --main-color: #1c1c1c">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub.pl - Pong</title>

    <link rel="stylesheet" type="text/css" href="style.css">

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>
    <script src="achievement_data.js"></script>
    <script src="screen.js"></script>
    <script src="pooong.js"></script>

</head>
<body class="game">

    <button onclick="StartGame()" class="start_game_button"><i class="fa-solid fa-play"></i></button>
    <canvas></canvas>

    <h1>Pong</h1>
    <h2>Opis gry</h2>
    <span>
        
        Prowadź węża po planszy, zjadaj jabłka i stawaj się coraz większy! <br> 
        Czerwone jabłko daje Ci 1 punkt, złote jabłko daje Ci 5 punktów <br> 
        Im dłuższy jest wąż, tym szybsza jest gra


    </span>
    <h2>Sterowanie</h2>
    <h3>Myszka</h3>
    <span>Ruch myszą </span>
    <h3>Telefon</h3>
    <span>Przesunięcie w danym kierunku sprawi, że wąż zacznie iść w tym samym kierunku</span>
    
</body>
</html>