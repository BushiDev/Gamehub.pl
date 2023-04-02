<?php

    session_start();

    if(!isset($_POST['submit'])){

        header("Location: register.php");

    }

    unset($_POST['submit']);

    $can_login = true;

    if(!isset($_POST['e-mail']) || $_POST['e-mail'] == ""){

        $can_login = false;

        $_SESSION['e_e-mail'] = "Niepoprawny adres e-mail";

    }

    if(!isset($_POST['password']) || $_POST['password'] == ""){

        $can_login = false;

        $_SESSION['e_password'] = "Niepoprawne hasło";

    }

    if($_POST['e-mail'] != filter_var($_POST['e-mail'], FILTER_SANITIZE_EMAIL)){

        $can_login = false;
        $_SESSION['e_e-mail'] = "Niepoprawny adres e-mail";

    }

    if($can_login){

        require_once("db_data.php");

        $connection = @new mysqli($db_host, $db_user, $db_password, $db_name);

        if($connection->connect_errno != 0){

            $can_login = false;
            $_SESSION['e_server'] = "Wystąpił błąd. Prosimy spróbować ponownie później";

        }else{

            $sql = 'SELECT * FROM users WHERE `e-mail` = "'.$_POST['e-mail'].'"';

            if($result = $connection->query($sql)){

                if($result->num_rows != 0){

                    if($row = $result->fetch_assoc()){

                        $password_hash = md5($_POST['password']);

                        if($row['password'] == $password_hash){

                            if($row['e-mail_confirmed'] == 1){

                                $_SESSION['user_data'] = $row;
                                header("Location: index.php");
    
                            }else{
    
                                $can_login = false;
    
                                $_SESSION['e_e-mail'] = "Adres e-mail przypisany do tego konta, nie został jeszcze potwierdzony. Prosimy potwierdzić adres e-mail";
    
                                header("Location: login.php");
    
                            }

                        }else{

                            $_SESSION['e_password'] = "Niepoprawne hasło";
                            header("Location: login.php");

                        }

                    }

                }else{

                    $_SESSION['e_e-mail'] = "Konto o takim adresie e-mail nie istnieje";
                    header("Location: login.php");

                }

            }else{

                $_SESSION['e_e-mail'] = "Konto o takim adresie e-mail nie istnieje";
                header("Location: login.php");

            }

        }

    }else{

        header("Location: login.php");

    }

?>