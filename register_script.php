<?php

    session_start();

    if(!isset($_POST['submit'])){

        header("Location: register.php");

    }

    unset($_POST['submit']);

    $can_register = true;

    if(!isset($_POST['e-mail']) || $_POST['e-mail'] == ""){

        $can_register = false;
        $_SESSION['e_e-mail'] = 'Proszę podać adres e-mail';

    }

    if(!isset($_POST['password']) || $_POST['password'] == ""){

        $can_register = false;
        $_SESSION['e_password'] = 'Hasło nie może być puste';

    }

    if(strlen($_POST['password']) < 5 || strlen($_POST['password']) > 20){

        $can_register = false;
        $_SESSION['e_password'] = 'Hasło musi zawierać od 5 do 20 znaków!';

    }

    if(!isset($_POST['password_repeat']) || $_POST['password_repeat'] == ""){

        $can_register = false;
        $_SESSION['e_password_repeat'] = "Proszę wpisać hasło ponownie";

    }

    if($_POST['password'] != $_POST['password_repeat']){

        $can_register = false;
        $_SESSION['e_password_repeat'] = "Hasła różnią się od siebie";

    }

    if($_POST['e-mail'] != filter_var($_POST['e-mail'], FILTER_SANITIZE_EMAIL)){

        $can_register = false;
        $_SESSION['e_e-mail'] = "Proszę podać poprawny adres e-mail";

    }

    if($can_register){

        require_once("db_data.php");

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if($connection->connect_errno != 0){

            $can_register = false;
            $_SESSION['e_server'] = "Wystąpił błąd. Proszę spróbować ponownie poźniej";

            $connection->close();

        }else{

            $sql = 'SELECT * FROM users WHERE `e-mail` = "'.$_POST['e-mail'].'";';

            if($result = $connection->query($sql)){

                if($result->num_rows != 0){

                    $can_register = false;
                    $_SESSION['e_e-mail'] = "Na podany adres e-mail, zostało już założone konto";

                    $connection->close();

                }

            }else{

                $can_register = false;
                $_SESSION['e_server'] = "Wystąpił błąd. Proszę spróbować ponownie poźniej";

                $connection->close();

            }

        }

        if($can_register){

            $password_hash = md5($_POST['password']);
            $current_date = date("Y-m-d");

            $sql = 'INSERT INTO users(`e-mail`, `password`, `register_date`) VALUES ("'.$_POST['e-mail'].'", "'.$password_hash.'", "'.$current_date.'")';
           
            if($connection->query($sql)){

                $sql = 'SELECT * FROM users WHERE `e-mail` = "'.$_POST['e-mail'].'"';

                if($result = $connection->query($sql)){

                    if($row = $result->fetch_assoc()){

                        echo "okk1 \n";

                        $sql = 'UPDATE users SET show_name = "player_'.$row['id'].'" WHERE id = '.$row['id'];
                        $connection->query($sql);

                        $sql = 'INSERT INTO pong_scoreboard(player_id) VALUES ("'.$row['id'].'")';
                        $connection->query($sql);
                        $sql = 'INSERT INTO snake_scoreboard(player_id) VALUES ("'.$row['id'].'")';
                        $connection->query($sql);
                        $sql = 'INSERT INTO tic_tac_toe_scoreboard(player_id) VALUES ("'.$row['id'].'")';
                        $connection->query($sql);

                        $subject = "Gamehub - Rejestracja";
                        $message = "Dziękujemy za rejestrację w naszym serwisie. Prosimy o potwierdzenie adresu e-mail, poprzez kliknięcię poniższego linku. Życzczymy miłego spędzania czasu, na naszej stronie <br>";
                        $link = "https://127.0.0.1/gamehub.pl/verify_email.php?id=".$row['id'];
                        $message .= "<a href='".$link."'>".$link."</a>";

                        if(mail($_POST['e-mail'], $subject, $message)){

                            if(isset($_GET['r']) && $_GET['r'] != ""){
            
                                header("Location: ".$_GET['r']);
                
                            }else{
                
                                header("Location: after_register.php");
                
                            }
            
                        }else{
            
                            echo "Nieeeeeee";
            
                        }

                    }

                }

            }

        }else{

            header("Location: rejestracja");

        }

    }else{

        header("Location: register.php");

    }

?>