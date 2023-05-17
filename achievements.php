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
    <title>Gamehub - Osiągnięcia</title>

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="style.css?v=34">
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

    <main class="achievements">

        <h1>Osiągnięcia</h1>

        <?php
        
            require_once("db_data.php");

            $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

            if($connection->connect_errno == 0){

                $sql = 'SELECT a.id, a.name, a.description, a.level, a.category, CASE WHEN a.id IN (SELECT c.achievement_id FROM collected_achievements AS c WHERE c.user_id = '.$_SESSION['user_data']['id'].') THEN true ELSE false END AS "is_owned" FROM achievements AS a ORDER BY a.category DESC, a.level, is_owned DESC, a.id;';

                if($result = $connection->query($sql)){

                    $last_category = "";

                    while($row = $result->fetch_assoc()){

                        if($last_category != $row['category']){

                            echo "<h2>".$row['category']."</h2>";
                            $last_category = $row['category'];

                        }

                        $level = $row['is_owned'] ? $row['level'] : "blocked";
                        $html = '<div class="achievement '.$level.'" id="ac_'.$row['id'].'"><img src="images/achievements/'.$row['id'].'.png"><div></div><span class="name">'.$row['name'].'</span><span class="description">'.$row['description'].'</span></div>';
                        echo $html;

                    }

                }

            }

        ?>


    </main>
    
</body>
</html>