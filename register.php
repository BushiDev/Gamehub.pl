<?php

    session_start();

    if(isset($_SESSION['user_data'])){

        header("Location: gry");

    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub - Rejestracja</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css?v=5">
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
        
            <form action="register_script.php" method="post" class="register">

                <h1>Rejestracja</h1>

                <span>

                    <input type="text" name="e-mail" placeholder="Adres e-mail">
                    <?php
                    
                        if(isset($_SESSION['e_e-mail'])){

                            echo '<span class="error"><i class="fa-solid fa-triangle-exclamation"></i><span>'.$_SESSION['e_e-mail'].'</span></span>';
                            unset($_SESSION['e_e-mail']);

                        }
                    
                    ?>

                </span><br>

                <span>

                    <input type="password" name="password" placeholder="Hasło">
                    <?php
                    
                        if(isset($_SESSION['e_password'])){

                            echo '<span class="error"><i class="fa-solid fa-triangle-exclamation"></i><span>'.$_SESSION['e_password'].'</span></span>';
                            unset($_SESSION['e_password']);

                        }
                    
                    ?>

                </span><br>
                <span>

                    <input type="password" name="password_repeat" placeholder="Powtórz hasło">
                    <?php
                    
                        if(isset($_SESSION['e_password_repeat'])){

                            echo '<span class="error"><i class="fa-solid fa-triangle-exclamation"></i><span>'.$_SESSION['e_password_repeat'].'</span></span>';
                            unset($_SESSION['e_password_repeat']);

                        }
                    
                    ?>

                </span><br>
                <a href="logowanie">Zaloguj się</a>
                <input type="submit" value="Zarejestruj się" name="submit">              
            
            </form>

        </div>

    </main>

</body>
</html>