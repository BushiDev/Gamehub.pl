var StartGame;

document.addEventListener("DOMContentLoaded", function(){

    var is_game_paused = false;

    var canvas = document.querySelector("canvas");
    var ctx = canvas.getContext("2d");

    var canvas_data = {

        size: 0,
        background: "#272727"

    };

    function setup_canvas(){

        if(window.innerWidth > window.innerHeight){

            canvas_data.size = window.innerHeight;
            rotate("landscape");

        }else{

            canvas_data.size = window.innerWidth;
            rotate("portrait");

        }

        canvas.width = canvas.height = canvas_data.size;

    }

    var tile_data = {

        count: 50,
        size: 0

    };

    function setup_tile_data(){

        tile_data.size = canvas_data.size / tile_data.count;

    }

    var snake = {

        position: {

            x: 0,
            y: 0

        },

        colors: {

            head: "#00f",
            parts: "#80e872"

        },

        velocity: {

            x: -1,
            y: 0

        }, 

        tail: [],

        is_alive: true

    };

    function setup_snake(){

        snake.position = {

            x: Math.floor(Math.random() * tile_data.count) * tile_data.size,
            y: Math.floor(Math.random() * tile_data.count) * tile_data.size

        };

        snake.tail.length = 0;

        snake.velocity.x = snake.position.x > canvas_data.size / 2 ? -1 : 1;
        snake.velocity.y = 0;

    }

    var apple = {

        position: {

            x: 0,
            y: 0

        },

        color: "#f30"

    };

    var golden_apple = {

        minimum_score: 15,
        chance: 5, // in %
        score_reward: 5,
        is_on_board: false,
        position: {

            x: 0,
            y: 0

        },

        color: "#ca0"

    };

    function setup_apple(){

        apple.position = {

            x: Math.floor(Math.random() * tile_data.count) * tile_data.size,
            y: Math.floor(Math.random() * tile_data.count) * tile_data.size

        };

    }

    function setup_golden_apple(){

        if(golden_apple.is_on_board || snake.tail.length < golden_apple.minimum_score) return;

        lucky = Math.random() * 100;
        if(lucky <= golden_apple.chance){

            golden_apple.is_on_board = true;

            golden_apple.position = {

                x: Math.floor(Math.random() * tile_data.count) * tile_data.size,
                y: Math.floor(Math.random() * tile_data.count) * tile_data.size
        
            };

        }

    }

    function draw_canvas(){

        ctx.fillStyle = canvas_data.background;
        ctx.fillRect(0, 0, canvas_data.size, canvas_data.size);

    }

    function draw_snake(){

        ctx.fillStyle = snake.colors.head;
        ctx.fillRect(snake.position.x, snake.position.y, tile_data.size, tile_data.size);

        ctx.fillStyle = snake.colors.parts;
        for(var i = 0; i < snake.tail.length; i++){

            ctx.fillRect(snake.tail[i].x, snake.tail[i].y, tile_data.size, tile_data.size);

        }

    }

    function draw_apple(){

        ctx.fillStyle = apple.color;
        ctx.fillRect(apple.position.x, apple.position.y, tile_data.size, tile_data.size);

    }

    function move_snake(){

        snake.position.x += snake.velocity.x * tile_data.size;
        snake.position.y += snake.velocity.y * tile_data.size;

    }

    function move_tail(){

        for(var i = snake.tail.length - 1; i > 0; i--){

            snake.tail[i].x = snake.tail[i - 1].x;
            snake.tail[i].y = snake.tail[i - 1].y;

        }

        if(snake.tail.length){

            snake.tail[0].x = snake.position.x;
            snake.tail[0].y = snake.position.y;

        }

    }

    function check_apple_collision(){

        if(Math.abs(apple.position.x - snake.position.x) < 0.1 && Math.abs(apple.position.y - snake.position.y) < 0.1){

            setup_apple();
            snake.tail.push({x: snake.position.x, y: snake.position.y});
            game_speed += 0.3;
            setup_golden_apple();

        }

    }

    function check_game_border(){

        if(snake.position.x < -2 * tile_data.size || snake.position.y < -2 * tile_data.size || snake.position.x > canvas_data.size + tile_data.size || snake.position.y > canvas_data.size + tile_data.size){

            snake.is_alive = false;
            show_death_screen();

        }

    }

    function check_tail_collision(){

        snake.tail.forEach(tail_element => {

            if(Math.abs(snake.position.x - tail_element.x) < 0.1 && Math.abs(snake.position.y - tail_element.y) < 0.1){

                snake.is_alive = false;
                show_death_screen();

            }
            
        });
        
    }

    function change_snake_direction(e){

        if(e.keyCode == 65){

            if(snake.velocity.x == 1) return;
            snake.velocity = {

                x: -1,
                y: 0

            };

        }

        if(e.keyCode == 68){

            if(snake.velocity.x == -1) return;
            snake.velocity = {

                x: 1,
                y: 0

            };

        }

        if(e.keyCode == 83){

            if(snake.velocity.y == -1) return;
            snake.velocity = {

                x: 0,
                y: 1

            };

        }

        if(e.keyCode == 87){

            if(snake.velocity.y == 1) return;
            snake.velocity = {

                x: 0,
                y: -1

            };

        }

    }

    document.addEventListener("keyup", change_snake_direction);

    var touch_data = {

        x: 0,
        y: 0

    }

    function start_touch(e){

        e.preventDefault();

        touch_data = {

            x: e.touches[0].pageX,
            y: e.touches[0].pageY

        }

    }
    
    function touch_move(e){

        e.preventDefault();

        var offset = {

            x: touch_data.x - e.touches[0].pageX,
            y: touch_data.y - e.touches[0].pageY,

        }

        if(Math.abs(offset.x) > Math.abs(offset.y)){

            if(offset.x > 0){

                change_snake_direction({keyCode: 65});

            }else{

                change_snake_direction({keyCode: 68});

            }

        }else{

            if(offset.y > 0){

                change_snake_direction({keyCode: 87});

            }else{

                change_snake_direction({keyCode: 83});

            }


        }

        /*ctx.font = "Arial 720px";
        ctx.fillText("x: "+offset.x, 50, 100);
        ctx.fillText("Y: "+offset.y, 50, 200);*/
        
    }

    canvas.addEventListener("touchstart", start_touch);
    canvas.addEventListener("touchmove", touch_move);

    var game_speed = 7;

    var t;

    function show_score(){

        var score_text = "Punkty: " + snake.tail.length;

        ctx.font = canvas_data.size / 20 + "px Arial";
        ctx.fillStyle = "#fff";
        ctx.textAlign = "left";
        ctx.fillText(score_text, 10, canvas_data.size / 20);

    }

    function show_death_screen(){

        var score_text = "Twoje punkty: " + snake.tail.length;

        ctx.fillStyle = canvas_data.background;
        ctx.fillRect(0, 0, canvas_data.size, canvas_data.size);

        ctx.fillStyle = "#c00";
        ctx.font = canvas_data.size / 15 + "px Arial";
        ctx.textAlign = "center";
        ctx.fillText("Przegrałeś/aś", canvas_data.size / 2, canvas_data.size / 6.5);

        ctx.fillStyle = "#fff";
        ctx.font = canvas_data.size / 24 + "px Arial";
        ctx.textAlign = "center";
        ctx.fillText(score_text, canvas_data.size / 2, canvas_data.size / 4.5);

        ctx.font = canvas_data.size / 24 + "px Arial";
        ctx.textAlign = "center";
        ctx.fillText("Chcesz zagrać ponownie?", canvas_data.size / 2, canvas_data.size / 2.75);

        ctx.fillText("Nie", canvas_data.size / 4, canvas_data.size / 1.5);
        ctx.fillText("Tak", canvas_data.size / 4 * 3, canvas_data.size / 1.5);

        console.warn("Death confirmed");

        var xmlhttp_get_count = new XMLHttpRequest();
        xmlhttp_get_count.onreadystatechange = function(){

            console.log("get count")

            if(xmlhttp_get_count.readyState == 4 && xmlhttp_get_count.status == 200){

                var new_value = parseInt(xmlhttp_get_count.responseText);
                new_value++;

                console.log("update count");

                var xmlhttp_set_count = new XMLHttpRequest();
                xmlhttp_set_count.open("GET", "score.php?g=snake&p=games_played&o=set&v=" + new_value);
                xmlhttp_set_count.send();

            }

        };
        xmlhttp_get_count.open("GET", "score.php?g=snake&p=games_played&o=get");
        xmlhttp_get_count.send();

        var xmlhttp_get_score = new XMLHttpRequest();
        xmlhttp_get_score.onreadystatechange = function(){

            console.log("get score")

            if(xmlhttp_get_score.readyState == 4 && xmlhttp_get_score.status == 200){

                var saved_score = parseInt(xmlhttp_get_score.responseText);
                if(snake.tail.length > saved_score){

                    console.log("update score");

                    var xmlhttp_set_count = new XMLHttpRequest();
                    xmlhttp_set_count.open("GET", "score.php?g=snake&p=max_score&o=set&v=" + snake.tail.length);
                    xmlhttp_set_count.send();

                }


            }

        };
        xmlhttp_get_score.open("GET", "score.php?g=snake&p=max_score&o=get");
        xmlhttp_get_score.send();

    }

    function death_decision(e){

        if(snake.is_alive) return;

        var position = {

            x: e.clientX - canvas.offsetLeft,
            y: e.clientY - canvas.offsetTop

        };

        console.log(position);

        if(position.y > canvas_data.size / 12 && position.y < canvas_data.size / 6){

            if(position.x < -canvas_data.size / 6 && position.x > -canvas_data.size / 3){

                window.location = "gry";

            }

            if(position.x > canvas_data.size / 6 && position.x < canvas_data.size / 3){

                StartGame();

            }

        }

    }

    canvas.addEventListener("click", death_decision);

    function touch_death_decistion(e){

        var data = {

            clientX: e.touches[0].pageX,
            clientY: e.touches[0].pageY

        };

        death_decision(data);

    }

    canvas.addEventListener("touchstart", touch_death_decistion);

    function draw_pause_button(){

        ctx.strokeStyle = "#fff";
        ctx.lineWidth = canvas_data.size / 80;
        ctx.beginPath();
        ctx.moveTo(canvas_data.size / 2 - ctx.lineWidth, 20);
        ctx.lineTo(canvas_data.size / 2 - ctx.lineWidth, canvas_data.size / 15);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(canvas_data.size / 2 + ctx.lineWidth, 20);
        ctx.lineTo(canvas_data.size / 2 + ctx.lineWidth , canvas_data.size / 15);
        ctx.stroke();

    }

    function handle_pause_button_click(e){

        if(is_game_paused || !snake.is_alive) return;

        var position = {

            x: e.clientX - canvas.getBoundingClientRect().x,
            y: e.clientY - canvas.getBoundingClientRect().y

        };

        if(position.x > canvas_data.size / 2 - canvas_data.size / 40 && position.x < canvas_data.size / 2 + canvas_data.size / 40 && position.y < canvas_data.size / 13){

            is_game_paused = true;
            show_pause_menu();

        }

    }

    function draw_golden_apple(){

        if(golden_apple.is_on_board){

            ctx.fillStyle = golden_apple.color;
            ctx.fillRect(golden_apple.position.x, golden_apple.position.y, tile_data.size, tile_data.size);

        }

    }

    function check_golden_apple_collision(){

        if(Math.abs(golden_apple.position.x - snake.position.x) < 0.1 && Math.abs(golden_apple.position.y - snake.position.y) < 0.1){

            golden_apple.is_on_board = false;
            for(var i = 0; i < golden_apple.score_reward; i++){

                snake.tail.push({x: snake.position.x, y: snake.position.y});
                game_speed += 0.3;

            }
            
        }

    }

    canvas.addEventListener("click", handle_pause_button_click);
    canvas.addEventListener("touchstart", function(e){

        var data = {
            clientX: e.touches[0].pageX,
            clientY: e.toches[0].pageY
        };

        handle_pause_button_click(data);

    });

    function show_pause_menu(){;

        var score_text = "Twoje punkty: " + snake.tail.length;

        ctx.fillStyle = canvas_data.background;
        ctx.fillRect(0, 0, canvas_data.size, canvas_data.size);

        ctx.fillStyle = snake.colors.head;
        ctx.font = canvas_data.size / 15 + "px Arial";
        ctx.textAlign = "center";
        ctx.fillText("Gra zatrzymana", canvas_data.size / 2, canvas_data.size / 5.5);

        ctx.fillStyle = "#fff";
        ctx.font = canvas_data.size / 24 + "px Arial";
        ctx.textAlign = "center";
        ctx.fillText(score_text, canvas_data.size / 2, canvas_data.size / 3.5);

        ctx.font = canvas_data.size / 24 + "px Arial";
        ctx.textAlign = "center";
        ctx.fillText("Wróć do gry", canvas_data.size / 2, canvas_data.size / 1.75);

    }

    function handle_return_game_button_click(e){

        if(!is_game_paused || !snake.is_alive) return;

        var position = {

            x: e.clientX - canvas.getBoundingClientRect().x,
            y: e.clientY - canvas.getBoundingClientRect().y

        };

        if(position.x > canvas_data.size / 2 - canvas_data.size / 6 && position.x < canvas_data.size / 2 + canvas_data.size / 6 && position.y > canvas_data.size / 2 && position.y < canvas_data.size / 2 + canvas_data.size / 12){

            is_game_paused = false;
            game_loop();

        }

    }

    canvas.addEventListener("click", handle_return_game_button_click);

    function game_loop(){

        if(!snake.is_alive) return; 
        if(is_game_paused) return;       

        draw_canvas();
        draw_snake();
        draw_apple();
        draw_golden_apple();

        draw_pause_button();

        show_score();

        move_tail();
        move_snake();
        check_game_border();
        check_tail_collision();
        check_apple_collision();
        check_golden_apple_collision();

        clearTimeout(t);
        t = setTimeout(game_loop, 1000 / game_speed);

    }

    StartGame = function(){

        document.querySelector("button").style.setProperty("display", "none");

        var xmlhttp_main = new XMLHttpRequest();

        xmlhttp_main.onreadystatechange = function(){

            if(xmlhttp_main.readyState == 4 && xmlhttp_main.status == 200){

                snake.colors.head = xmlhttp_main.responseText;

            }

        };

        xmlhttp_main.open("GET", "user_data.php?p=color&o=get");
        xmlhttp_main.send();

        var xmlhttp_alternative = new XMLHttpRequest();

        xmlhttp_alternative.onreadystatechange = function(){

            if(xmlhttp_alternative.readyState == 4 && xmlhttp_alternative.status == 200){

                snake.colors.parts = xmlhttp_alternative.responseText;

            }

        };

        xmlhttp_alternative.open("GET", "user_data.php?p=alternative_color&o=get");
        xmlhttp_alternative.send();

        game_speed = 7;
        snake.is_alive = true;
        is_game_paused = false;

        console.log(snake);

        setup_canvas();
        setup_tile_data();
        setup_snake();
        setup_apple();

        game_loop();

    }

});