<?php

    session_start();

    if(!isset($_SESSION['user_data'])){

        header("Location: logowanie?r=tic_tac_toe");

    }

?>

<!DOCTYPE html>
<html lang="pl" style="--secondary-color: <?php echo $_SESSION['user_data']['color'] ?>; --main-color: #1c1c1c">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub.pl - Tic Tac Toe</title>

    <link rel="stylesheet" type="text/css" href="style.css?v=4">

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>
    <script src="achievement_data.js"></script>
    <script src="screen.js"></script>
    <script src="tic_tac_toe.js"></script>

</head>
<body class="game">

    <button onclick="StartGame()" class="start_game_button"><i class="fa-solid fa-play"></i></button>
    <canvas></canvas>

    <h1>Tic Tac Toe</h1>
    <h2>Opis gry</h2>
    <span>
        
        Wybierz swój symbol i graj przeciwko AI w grze znanej na całym świecie


    </span>
    <h2>Sterowanie</h2>
    <h3>Myszka</h3>
    <span>Kliknij kursorem myszy w wybrany kwadrat</span>
    <h3>Telefon</h3>
    <span>Tapnij w wybrany kwadrat</span>
    
</body>
</html>