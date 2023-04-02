<?php

    if(!isset($_GET['code']) || $_GET['code'] == ""){

        header("Location: gry");

    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub - Błąd 404</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css?v=1">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="manifest" href="manifest.json">

</head>
<body>

    <header>

    <span class="logo">

        Game<span class="logo_color">hub</span>

    </span>

    </header>

    <main>

        <div class="box">
        
            <div class="error_textbox">

                <h3>Błąd</h3>
                <h1><?php
                
                    echo $_GET['code'];

                ?></h1>
                <h4><?php
                
                    switch($_GET['code']){

                        case "403":
                            echo "Brak dostępu";
                            break;
                        case "404":
                            echo "Strona nie została znaleziona";
                            break;
                        case "500":
                            echo "Błąd serwera";
                            break;
                        case "503":
                            echo "Serwis tymczasowo niedostępny";
                            break;
                        default:
                            echo "Wystąpił nieznany błąd";
                            break;

                    }
                
                ?></h4>

                <span>Przekierowanie na stronę główną za <span id="timer">5</span>...</span>
                <script>

                    var timer_text = document.querySelector("span#timer");
                    var time = 5;

                    setInterval(function(){

                        timer_text.innerHTML = time;
                        time--;

                        if(time < 0){

                            window.location = "gry";

                        }

                    }, 1000);

                </script>

            </div>

        </div>

    </main>

</body>
</html>