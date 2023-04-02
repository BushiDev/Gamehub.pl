<?php

    session_start();

    if(!isset($_SESSION['user_data'])){

        header("Location: login.php");

    }

?>

<!DOCTYPE html>
<html lang="pl" style="--secondary-color: <?php echo $_SESSION['user_data']['color'] ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub - Ustawienia konta</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>
    <script src="settings.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="style.css">
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

    <main class="settings">

        Nick<br>
        <input type="text" maxlength="13" id="show_name" value="<?php echo $_SESSION['user_data']['show_name']; ?>"> <button onclick="change_name()">Zmień</button> <br><br><br>

        Zdjęcie profilowe<br>
        <?php 

            $html = '<img src="images/avatars/'.$_SESSION['user_data']['avatar'].'.png" id="player_avatar">';
        
            echo $html; 

            $directory = __DIR__."/images/avatars/";
            $filecount = count(glob($directory . "*.png"));

            for($i = 0; $i < $filecount; $i++){

                if($i % 3 == 0){

                    echo "<br>";

                }

                $html = '<img class="preview" src="images/avatars/'.$i.'.png" onclick="change_avatar('.$i.');">';
                echo $html;

            }
        
        ?><br><br><br>

        Kolor w grach<br>
        <button class="color_changer" style="--color: #f00" onclick="change_color('f00')"></button>
        <button class="color_changer" style="--color: #ffa31a" onclick="change_color('ffa31a')"></button>
        <button class="color_changer" style="--color: #ff0" onclick="change_color('ff0')"></button><br>

        <button class="color_changer" style="--color: #0f0" onclick="change_color('0f0')"></button>
        <button class="color_changer" style="--color: #0ff" onclick="change_color('0ff')"></button>
        <button class="color_changer" style="--color: #08f" onclick="change_color('08f')"></button><br>

        <button class="color_changer" style="--color: #00f" onclick="change_color('00f')"></button>
        <button class="color_changer" style="--color: #80f" onclick="change_color('80f')"></button>
        <button class="color_changer" style="--color: #f0f" onclick="change_color('f0f')"></button>

        <div class="addon"></div>

    </main>
    
</body>
</html>