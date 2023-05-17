<?php

    require_once("db_data.php");

    $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

    if($connection->connect_errno != 0){

        echo "Nie można połączyć się z bazą danych!";

    }else{

        /*
        [

                "name" => "",
                "description" => "",
                "level" => "",
                "category" => ""

            ]
        
        */

        $achievements = [

            [

                "name" => "Mam na imię...",
                "description" => "Ustaw swój nick",
                "level" => "bronze",
                "category" => "Konto"

            ],
            [

                "name" => "Ja tak nie wyglądam!",
                "description" => "Zmień swój awatar",
                "level" => "bronze",
                "category" => "Konto"

            ],
            [

                "name" => "Uwielbiam ten kolor!",
                "description" => "Zmień swój kolor główny w grach",
                "level" => "bronze",
                "category" => "Konto"

            ],
            [

                "name" => "Ten kolor też lubię",
                "description" => "Zmień swój kolor alternatywny w grach",
                "level" => "bronze",
                "category" => "Konto"

            ],
            [

                "name" => "To już rok",
                "description" => "Posiadaj konto rok, lub dłużej",
                "level" => "bronze",
                "category" => "Konto"

            ],
            [

                "name" => "Ale długi!",
                "description" => "Zdobądź przynajmniej 30 punktów w grze Snake",
                "level" => "bronze",
                "category" => "Gry - Snake"

            ],
            [

                "name" => "Jeszcze dłuższy",
                "description" => "Zdobądź przynajmniej 70 punktów w grze Snake",
                "level" => "bronze",
                "category" => "Gry - Snake"

            ],
            [

                "name" => "Wzloty i upadki",
                "description" => "Wygraj i przegraj w grze Tic Tac Toe 10 razy",
                "level" => "bronze",
                "category" => "Gry - Tic Tac Toe"

            ],
            [

                "name" => "Równi sobie",
                "description" => "Zremisuj w grze Tic Tac Toe 10 razy",
                "level" => "bronze",
                "category" => "Gry - Tic Tac Toe"

            ]

        ];

        foreach ($achievements as $achievement){
            
            $sql = 'INSERT INTO achievements(name, description, level, category) VALUES("'.$achievement['name'].'", "'.$achievement['description'].'", "'.$achievement['level'].'", "'.$achievement['category'].'")';
            echo $sql."<br>";
            $connection->query($sql);

        }

        $connection->close();
        echo "Done!";

    }

?>