<?php

    session_start();

    if(!isset($_SESSION['user_data'])){

        header("Location: logowanie?r=tic_tac_toe");

    }

?>

<!DOCTYPE html>
<html lang="pl" style="--secondary-color: <?php echo $_SESSION['user_data']['color'] ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamehub.pl - Tic Tac Toe</title>

    <link rel="stylesheet" type="text/css" href="style.css?v=1">

    <script src="https://kit.fontawesome.com/736d7541bb.js" crossorigin="anonymous"></script>
    <script src="screen.js"></script>
    <script>

var StartGame;

var table = [[], [], []];

document.addEventListener("DOMContentLoaded", function () {

    var player_color = "#0ff";
    var enemy_color = "#80e872";

    var turn = -1;

    console.log(turn);

    var canvas = document.querySelector("canvas");
    var ctx = canvas.getContext("2d");

    function setup_table() {

        for (var i = 0; i < 3; i++) {

            table[i] = [];

            for (var j = 0; j < 3; j++) {

                table[i][j] = null;

            }

        }

        console.table(table);

    }

    setup_table();

    var canvas_data = {

        width: window.innerWidth,
        height: window.innerHeight,

        background: "#272727",

        lines: {

            width: window.innerWidth / 50,
            color: "#fff"

        },

        table_size: window.innerHeight

    };

    function check_orientation() {

        if (canvas_data.width > canvas_data.height) {

            canvas_data.table_size = canvas_data.height;

        } else {

            canvas_data.table_size = canvas_data.width;

        }

        canvas.width = canvas.height = canvas_data.table_size;

        canvas_data.lines.width = canvas_data.table_size / 70;

    }

    function draw_canvas() {

        check_orientation();

        ctx.fillStyle = canvas_data.background;
        ctx.fillRect(0, 0, canvas_data.width, canvas_data.height);

        ctx.fillStyle = canvas_data.lines.color;

        for (var i = 0; i < 2; i++) {

            ctx.fillRect(
                canvas_data.table_size / 3 * (i + 1),
                0,
                canvas_data.lines.width,
                canvas_data.table_size
            );

        }

        for (var i = 0; i < 2; i++) {

            ctx.fillRect(
                0,
                canvas_data.table_size / 3 * (i + 1),
                canvas_data.table_size,
                canvas_data.lines.width
            );

        }

        let randomDealy = (Math.floor(Math.random() * 1500) + 200);
        setTimeout(enemy_move, randomDealy);

    }

    draw_canvas();

    function player_move(e) {

        if (turn == -1) 
            return;
        
        var x = e.clientX - canvas.getBoundingClientRect().x;
        var y = e.clientY - canvas.getBoundingClientRect().y;

        for (var i = 0; i < 3; i++) {

            for (var j = 0; j < 3; j++) {

                if (x > canvas_data.table_size / 3 * i && x < ((canvas_data.table_size / 3) * i) + canvas_data.table_size / 3) {

                    if (y > canvas_data.table_size / 3 * j && y < ((canvas_data.table_size / 3) * j) + canvas_data.table_size / 3) {

                        if (table[j][i] == 0) {

                            table[j][i] = turn;

                            draw_player(i, j);

                            if (check_table_status() == 0) {

                                turn = -1;
                                let randomDealy = (Math.floor(Math.random() * 1500) + 200);
                                setTimeout(enemy_move, randomDealy);

                            } else {

                                console.log(check_table_status())

                            }

                        }

                    }

                }

            }

        }

    }

    function enemy_move() {
        
        if (turn == -1) {

            let game_array = [];
            game_array.splice(0, game_array.length);

            for (var i = 0; i < 3; i++) {

                for (var j = 0; j < 3; j++) {

                    if (table[i][j] == 0) {

                        game_array.push({x: i, y: j});

                    }

                }

            }

            var randomBox = Math.floor(Math.random() * game_array.length);
            table[game_array[randomBox].x][game_array[randomBox].y] = turn;

            console.log(game_array[randomBox].x +" " +game_array[randomBox].y);

            draw_enemy(game_array[randomBox].x, game_array[randomBox].y);

            if (check_table_status() == 0) {

                turn = 1;

            } else {

                console.log(check_table_status())

            }

        }

    }

    function draw_player(x, y) {

        var center = {

            x: (canvas_data.table_size / 3) * x + canvas_data.table_size / 6,
            y: (canvas_data.table_size / 3) * y + canvas_data.table_size / 6

        }

        ctx.lineWidth = canvas_data.lines.width;
        ctx.strokeStyle = player_color;
        ctx.beginPath();
        ctx.moveTo(
            center.x - canvas_data.table_size / 6 + canvas_data.table_size / 20,
            center.y - canvas_data.table_size / 6 + canvas_data.table_size / 20
        );
        ctx.lineTo(
            center.x + canvas_data.table_size / 6 - canvas_data.table_size / 20,
            center.y + canvas_data.table_size / 6 - canvas_data.table_size / 20
        );
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(
            center.x + canvas_data.table_size / 6 - canvas_data.table_size / 20,
            center.y - canvas_data.table_size / 6 + canvas_data.table_size / 20
        );
        ctx.lineTo(
            center.x - canvas_data.table_size / 6 + canvas_data.table_size / 20,
            center.y + canvas_data.table_size / 6 - canvas_data.table_size / 20
        );
        ctx.stroke();

    }

    function draw_enemy(x, y) {

        var center = {

            x: (canvas_data.table_size / 3) * x + canvas_data.table_size / 6,
            y: (canvas_data.table_size / 3) * y + canvas_data.table_size / 6

        }

        ctx.lineWidth = canvas_data.lines.width;
        ctx.strokeStyle = enemy_color;

        ctx.beginPath();
        ctx.arc(
            center.x,
            center.y,
            canvas_data.table_size / 6 - canvas_data.table_size / 20,
            0,
            Math.PI * 2
        );
        ctx.stroke();

    }

    function check_table_status() {

        var status = 0;

        for (var i = 0; i < 3; i++) {

            if (table[i][0] == table[i][1] && table[i][1] == table[i][2] && table[i][0] != 0) {

                status = turn;
                ctx.strokeStyle = canvas_data.lines.color;
                ctx.lineWidth = canvas_data.lines.width / 3 * 2;
                ctx.beginPath();
                ctx.moveTo(
                    canvas_data.table_size / 30,
                    (canvas_data.table_size / 3) * i + canvas_data.table_size / 6
                );
                ctx.lineTo(
                    canvas_data.table_size - canvas_data.table_size / 30,
                    (canvas_data.table_size / 3) * i + canvas_data.table_size / 6
                );
                ctx.stroke();

            }

        }

        for (var i = 0; i < 3; i++) {

            if (table[0][i] == table[1][i] && table[1][i] == table[2][i] && table[1][i] != 0) {

                status = turn;
                ctx.strokeStyle = canvas_data.lines.color;
                ctx.lineWidth = canvas_data.lines.width / 3 * 2;
                ctx.beginPath();
                ctx.moveTo(
                    (canvas_data.table_size / 3) * i + canvas_data.table_size / 6,
                    canvas_data.table_size / 30
                );
                ctx.lineTo(
                    (canvas_data.table_size / 3) * i + canvas_data.table_size / 6,
                    canvas_data.table_size - canvas_data.table_size / 30
                );
                ctx.stroke();

            }

        }

        if (table[0][0] == table[1][1] && table[1][1] == table[2][2] && table[0][0] != 0) {

            status = turn;

        }

        if (table[0][2] == table[1][1] && table[1][1] == table[2][0] && table[1][1] != 0) {

            status = turn;;

        }

        return status;

    }

    canvas.addEventListener("click", player_move);

});

    </script>

</head>
<body>

<button onclick="StartGame()" class="start_game_button"><i class="fa-solid fa-play"></i></button>
<canvas></canvas>
    
</body>
</html>