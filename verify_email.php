<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gamehub - Weryfikacja e-mail</title>

        <link rel="stylesheet" type="text/css" href="style.css?v=2">
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

                <div class="email_verify">

                <?php

                    if(isset($_GET['id'])){ 

                        require_once("db_data.php"); $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

                        if($connection->connect_errno != 0){ 

                            echo "<h1>Wystąpił błąd. Prosimy spróbować ponownie</h1>";

                        }else{ 

                            $sql = "UPDATE users SET `e-mail_confirmed` = 1 WHERE `id` = ".$_GET['id'];
                            $connection->query($sql); 
                            echo "<h1>Pomyślnie zweryfikowano adres e-mail</h1>"; 
                        } 

                    }else{

                        echo "<h1>Wystąpił błąd. Prosimy spróbować ponownie</h1>";
                    
                    }

                    ?>

                    <span>Przekierowanie na stronę główną za <span id="timer">5</span>...</span>
                    <script>

                        var timer_text = document.querySelector("span#timer");
                        var time = 5;

                        setInterval(function () {

                            timer_text.innerHTML = time;
                            time--;

                            if (time < 0) {

                                window.location = "gry";

                            }

                        }, 1000);
                    </script>

                </div>

            </div>

        </main>

    </body>
</html>