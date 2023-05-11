var StartGame;

document.addEventListener("DOMContentLoaded", function(){

    var table = [[], [], []];

    var colors = {

        player: "#fff",
        enemy: "#fff"

    };

    var game_status = 0; //0 - waiting for player side, 1 - player move, 2 - enemy move, 3 - player win, 4 - enemy win, 5 - tie, 6 - wait for end decision
    var player_symbol = "";
    var player_can_move = false;

    var canvas_data = {

        size: 0,
        background: "#1c1c1c",
        lines: {

            color: "#fff",
            width: 0

        }

    };
    
    var canvas
    var context;

    function Check_Orientation(){

        if(window.innerWidth > window.innerHeight){

            canvas_data.size = window.innerHeight;
            rotate("landscape");

        }else{

            canvas_data.size = window.innerWidth;
            rotate("portrait");

        }

        canvas = document.querySelector("canvas");
        context = canvas.getContext("2d");

        canvas.width = canvas.height = canvas_data.size;
        canvas_data.lines.width = canvas_data.size / 100;

        canvas.addEventListener("click", function(e){

            var position = {
    
                x: e.clientX - canvas.getBoundingClientRect().x,
                y: e.clientY - canvas.getBoundingClientRect().y
    
            };
    
            Handle_Player_Side(position);
            Handle_Player_Click(position);
            Handle_End_Game_Decision(position);
    
        });

        canvas.addEventListener("touchstart", function(e){
    
            var position = {
    
                x: e.touches[0].pageX - canvas.getBoundingClientRect().x,
                y: e.toches[0].pageY - canvas.getBoundingClientRect().y
    
            };
    
            Handle_Player_Side(position);
            Handle_Player_Click(position);
            Handle_End_Game_Decision(position);
    
        });

    }

    function Setup_Table(){

        for(let x = 0; x < 3; x++){

            for(let y = 0; y < 3; y++){

                table[x][y] = null;

            }

        }

    }

    function Setup_Colors(){

        var xmlhttp_player = new XMLHttpRequest();

        xmlhttp_player.onreadystatechange = function(){

            if(xmlhttp_player.readyState == 4 && xmlhttp_player.status == 200){

                colors.player = xmlhttp_player.responseText;

            }

        };

        xmlhttp_player.open("GET", "user_data.php?p=color&o=get");
        xmlhttp_player.send();

        var xmlhttp_enemy = new XMLHttpRequest();

        xmlhttp_enemy.onreadystatechange = function(){

            if(xmlhttp_enemy.readyState == 4 && xmlhttp_enemy.status == 200){

                colors.enemy = xmlhttp_enemy.responseText;

            }

        };

        xmlhttp_enemy.open("GET", "user_data.php?p=alternative_color&o=get");
        xmlhttp_enemy.send();

    }

    function Handle_Player_Side(position){

        if(game_status != 0) return;

        if(position.y > canvas_data.size / 2 && position.y < canvas_data.size / 4 * 3){

            if(position.x < canvas_data.size / 2 - canvas_data.size / 12 && position.x > canvas_data.size / 2 - canvas_data.size / 4){

                player_symbol = "O";
                Draw_Table();
                game_status = 1;
                var t = setInterval(function(){

                    player_can_move = true;
                    clearInterval(t);

                }, 1000);

            }else if(position.x > canvas_data.size / 2 + canvas_data.size / 12 && position.x < canvas_data.size / 2 + canvas_data.size / 4){

                player_symbol = "X";
                game_status = 2;
                player_can_move = false;
                Draw_Table();

                let randomDealy = (Math.floor(Math.random() * 2000) + 300);
                setTimeout(Enemy_Move, randomDealy);


            }

        }

    }

    function Handle_Player_Click(e){

        if(game_status != 1 || !player_can_move) return;

        for (var i = 0; i < 3; i++) {

            for (var j = 0; j < 3; j++) {

                if (e.x > canvas_data.size / 3 * i && e.x < ((canvas_data.size / 3) * i) + canvas_data.size / 3) {

                    if (e.y > canvas_data.size / 3 * j && e.y < ((canvas_data.size / 3) * j) + canvas_data.size / 3) {

                        if (table[j][i] == null) {

                            table[j][i] = player_symbol;

                            if(player_symbol == "X"){

                                Draw_X({x: i, y: j}, colors.player);

                            }else{

                                Draw_O({x: i, y: j}, colors.player);

                            }

                            Check_Table_Status();

                        }

                    }

                }

            }

        }

    }

    function Enemy_Move(){

        if(game_status != 2) return;

        var ar = [];
        ar.splice(0, ar.length);
        for(let i = 0; i < 3; i++){

            for(let j = 0; j < 3; j++){

                if(table[j][i] == null){

                    ar.push({x: i, y: j});

                }

            }

        }

        var random = Math.floor(Math.random() * ar.length);
        if(player_symbol == "X"){

            table[ar[random].y][ar[random].x] = "O";
            Draw_O({x: ar[random].x, y: ar[random].y}, colors.enemy);

        }else{

            table[ar[random].y][ar[random].x] = "X";
            Draw_X({x: ar[random].x, y: ar[random].y}, colors.enemy);

        }

        Check_Table_Status();

    }

    function Check_Table_Status(){

        last_move = game_status;

        //columns
        for(let i = 0; i < 3; i++){

            if(table[0][i] == table[1][i] && table[1][i] == table[2][i] && table[1][i] != null){

                game_status = table[1][i] == player_symbol ? 3 : 4;

                context.fillStyle = canvas_data.lines.color;
                context.fillRect(canvas_data.size / 3 * i + canvas_data.size / 6 - canvas_data.lines.width / 2, canvas_data.size / 48, canvas_data.lines.width, canvas_data.size - canvas_data.size / 24);

            }

        }

        //rows
        for(let i = 0; i < 3; i++){

            if(table[i][0] == table[i][1] && table[i][1] == table[i][2] && table[i][1] != null){

                game_status = table[i][1] == player_symbol ? 3 : 4;

                context.fillStyle = canvas_data.lines.color;
                context.fillRect(canvas_data.size / 48, canvas_data.size / 3 * i + canvas_data.size / 6 - canvas_data.lines.width / 2, canvas_data.size - canvas_data.size / 24, canvas_data.lines.width);

            }

        }

        //cross
        if(table[0][0] == table[1][1] && table[1][1] == table[2][2] && table[1][1] != null){

            game_status = table[1][1] == player_symbol ? 3 : 4;

            context.strokeStyle = canvas_data.lines.color;
            context.lineWidth = canvas_data.lines.width;
            context.beginPath();
            context.moveTo(canvas_data.size / 48, canvas_data.size / 48);
            context.lineTo(canvas_data.size - canvas_data.size / 48, canvas_data.size - canvas_data.size / 48);
            context.stroke();

        }

        if(table[2][0] == table[1][1] && table[1][1] == table[0][2] && table[1][1] != null){

            game_status = table[1][1] == player_symbol ? 3 : 4;

            context.strokeStyle = canvas_data.lines.color;
            context.lineWidth = canvas_data.lines.width;
            context.beginPath();
            context.moveTo(canvas_data.size - canvas_data.size / 48, canvas_data.size / 48);
            context.lineTo(canvas_data.size / 48, canvas_data.size - canvas_data.size / 48);
            context.stroke();

        }

        if(game_status == 3 || game_status == 4){

            if(game_status == 3){

                var t = setTimeout(function(){

                    Draw_End_Menu("Wygrałeś/aś!", colors.player);
                    clearInterval(t);

                }, 1500);
                console.log("Player win");
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "score.php?g=tic_tac_toe&o=win");
                xmlhttp.send();

            }else{

                var t = setTimeout(function(){

                    Draw_End_Menu("Przegrałeś/aś!", colors.enemy);
                    clearInterval(t);

                }, 1500);
                console.log("Enemy Win");
                let xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "score.php?g=tic_tac_toe&o=loose");
                xmlhttp.send();

            }

        }else{

            game_status = 5;

            for(let i = 0; i < 3; i++){

                for(let j = 0; j < 3; j++){

                    if(table[j][i] == null){

                        game_status = last_move == 1 ? 2 : 1;

                    }

                }

            }

            if(game_status == 5){

                var t = setTimeout(function(){

                    Draw_End_Menu("Remis!", "#fff");
                    clearInterval(t);

                }, 1500);
                console.log("tie");

                let xmlhttp = new XMLHttpRequest();
                xmlhttp.open("GET", "score.php?g=tic_tac_toe&o=tie");
                xmlhttp.send();


            }else{

                player_can_move = game_status == 1;

                if(!player_can_move){

                    let randomDealy = (Math.floor(Math.random() * 1500) + 300);
                    var t = setTimeout(function(){

                        Enemy_Move();
                        clearInterval(t);

                    }, randomDealy);

                }

            }

        }

        console.log("Game status: "+game_status);

    }

    function Handle_End_Game_Decision(e){

        if(game_status == 6){

            if(e.y > canvas_data.size / 2 + canvas_data.size / 48 && e.y < canvas_data.size / 2 + canvas_data.size / 12){

                window.location = "gry";
                console.log("menu główne");

            }else if(e.y < canvas_data.size / 2 && e.y > canvas_data.size / 2 - canvas_data.size / 8){

                StartGame();

            }

        }

    }

    function Draw_O(position, color){

        var center = {

            x: (canvas_data.size / 3) * position.x + canvas_data.size / 6,
            y: (canvas_data.size / 3) * position.y + canvas_data.size / 6

        }

        context.lineWidth = canvas_data.lines.width * 3;
        context.strokeStyle = color;

        context.beginPath();
        context.arc(
            center.x,
            center.y,
            canvas_data.size / 6 - canvas_data.size / 20,
            0,
            Math.PI * 2
        );
        context.stroke();

    }

    function Draw_X(position, color){

        var center = {

            x: (canvas_data.size / 3) * position.x + canvas_data.size / 6,
            y: (canvas_data.size / 3) * position.y + canvas_data.size / 6

        }

        context.lineWidth = canvas_data.lines.width * 3;
        context.strokeStyle = color;
        context.beginPath();
        context.moveTo(
            center.x - canvas_data.size / 6 + canvas_data.size / 20,
            center.y - canvas_data.size / 6 + canvas_data.size / 20
        );
        context.lineTo(
            center.x + canvas_data.size / 6 - canvas_data.size / 20,
            center.y + canvas_data.size / 6 - canvas_data.size / 20
        );
        context.stroke();
        context.beginPath();
        context.moveTo(
            center.x + canvas_data.size / 6 - canvas_data.size / 20,
            center.y - canvas_data.size / 6 + canvas_data.size / 20
        );
        context.lineTo(
            center.x - canvas_data.size / 6 + canvas_data.size / 20,
            center.y + canvas_data.size / 6 - canvas_data.size / 20
        );
        context.stroke();

    }

    function Draw_Table(){

        context.fillStyle = canvas_data.background;
        context.fillRect(0, 0, canvas_data.size, canvas_data.size);
        context.fillStyle = canvas_data.lines.color;
        for(let i = 1; i <= 2; i++){

            context.fillRect(canvas_data.size / 3 * i - canvas_data.lines.width / 2, 0, canvas_data.lines.width, canvas_data.size);

        }

        for(let i = 1; i <= 2; i++){

            context.fillRect(0, canvas_data.size / 3 * i - canvas_data.lines.width / 2, canvas_data.size, canvas_data.lines.width);

        }

    }

    function Draw_Choose_Side_Menu(){

        context.fillStyle = canvas_data.background;
        context.fillRect(0, 0, canvas_data.size, canvas_data.size);

        context.fillStyle = colors.player;
        context.font = canvas_data.size / 12 + "px Arial";
        context.textAlign = "center";
        context.fillText("Wybierz swój symbol", canvas_data.size / 2, canvas_data.size / 4);

        context.fillStyle = canvas_data.lines.color;
        context.font = canvas_data.size / 5 + "px Arial";
        context.fillText("O", canvas_data.size / 3, canvas_data.size / 1.5);
        context.fillText("X", canvas_data.size / 3 * 2, canvas_data.size / 1.5);

    }

    function Draw_End_Menu(text, color){

        context.fillStyle = canvas_data.background;
        context.fillRect(0, 0, canvas_data.size, canvas_data.size);

        context.fillStyle = color;
        context.font = canvas_data.size / 12 + "px Arial";
        context.textAlign = "center";
        context.fillText(text, canvas_data.size / 2, canvas_data.size / 4);

        context.fillStyle = canvas_data.lines.color;
        context.font = canvas_data.size / 25 + "px Arial";
        context.fillText("Zagraj jeszcze raz", canvas_data.size / 2, canvas_data.size / 2);
        context.fillText("Wróć na stronę główną", canvas_data.size / 2, canvas_data.size / 1.75);

        setTimeout(function(){

            game_status = 6;
            console.log("Can end decision");

        }, 1000);

    }

    StartGame = function(){

        document.querySelector("body.game").innerHTML = "<canvas></canvas>";

        setTimeout(function(){

            game_status = 0;
            player_can_move = false;
            player_symbol = "";

            Check_Orientation();
            Setup_Colors();
            Setup_Table();
            setTimeout(function(){

                Check_Orientation();
                Draw_Choose_Side_Menu();

            }, 1000);

        }, 1000);
    }

});