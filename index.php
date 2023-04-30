<?php

    session_start();

    if(!isset($_SESSION['user_data'])){

        header("Location: logowanie");

    }

?>

<!DOCTYPE html>
<html lang="pl" style="--secondary-color: <?php echo $_SESSION['user_data']['color'] ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub - Stron główna</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="style.css?v=14">
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

    <main>

        <!--<article class="game">

            <img src="images/games/Pong.png" alt="Pong">
            <span>

                Pong

                <a href="pong">Graj</a>

            </span>

        </article>-->

        <article class="game">

            <img src="images/games/TicTacToe.png" alt="Tic Tac Toe">
            <span>

                Tic Tac Toe

                <a href="tic-tac-toe">Graj</a>

            </span>

        </article>

        <article class="game">

            <img src="images/games/Snake.png" alt="Snake">
            <span>

                Snake

                <a href="snake">Graj</a>

            </span>

        </article>

        <h1 class="game_ads">Więcej gier wkrótce!</h1>

    </main>
    
</body>
</html>