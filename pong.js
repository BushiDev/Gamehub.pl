var StartGame;

document.addEventListener("DOMContentLoaded", function(){

    var canvas = document.querySelector("canvas");
    var context = canvas.getContext("2d");

    var canvas_data = {

        size: {

            width: screen.width,
            height: screen.height,

        },

        background_color: "#c0c0c0",

        lines: {

            sizes: {

                width: screen.width / 128,
                height: screen.height / 30

            },

            color: "#272727"

        },

        circles: {

            width: screen.width / 128,

            x1: screen.width / 2 - 0.5,
            x2: 0,
            x3: screen.width,
            y: screen.height / 2,

            color1: "#272727",
            color2: "#00f",
            color3: "#f00",

            arc1: 2 * Math.PI,
            arc2: -Math.PI,

            radius: screen.height / 4

        }

    };

    console.log(canvas_data);

    var paddle_data = {

        width: screen.width / 100,
        height: screen.height / 4

    };

    var player_data = {

        position: {

            x: canvas_data.size.width - paddle_data.width * 3,
            y: canvas_data.size.height / 2 - paddle_data.height / 2

        },

        color: "#0ff",

        points: 0

    };

    var enemy_data = {

        position: {

            x: paddle_data.width * 2,
            y: canvas_data.size.height / 2 - paddle_data.height / 2

        },

        color: "#f0f",

        speed: {

            normal: 3,
            run: 12

        },

        points: 0

    };

    var ball_data = {

        size: screen.width / 40,
        
        position: {

            x: canvas_data.size.width / 2 - screen.width / 80,
            y: canvas_data.size.height / 2 - screen.width / 80

        },

        color: "#a0a",

        speed: {

            x: 3,
            y: 2

        }

    }

    function DrawTable(){

        context.fillStyle = canvas_data.background_color;
        context.fillRect(0, 0, canvas_data.size.width, canvas_data.size.height);

        context.fillStyle = canvas_data.lines.color;
        for(var i = canvas_data.lines.sizes.height / 2; i < canvas_data.size.height; i += canvas_data.lines.sizes.height){

            if(i < (canvas_data.size.height / 3) - canvas_data.lines.sizes.height * 2 || i > (canvas_data.size.height / 3 * 2) + canvas_data.lines.sizes.height * 2 ){

                context.fillRect(canvas_data.size.width / 2 - canvas_data.lines.sizes.width / 2, i, canvas_data.lines.sizes.width, canvas_data.lines.sizes.height);

            }

            i += canvas_data.lines.sizes.height;

        }

        context.lineWidth = canvas_data.circles.width;
        context.strokeStyle = canvas_data.circles.color1;

        context.beginPath();
        context.arc(canvas_data.circles.x1, canvas_data.circles.y, canvas_data.circles.radius, 0, canvas_data.circles.arc1);
        context.stroke();

        context.beginPath();
        context.arc(canvas_data.circles.x1, canvas_data.circles.y, canvas_data.circles.radius / 4, 0, canvas_data.circles.arc1);
        context.stroke();

        context.strokeStyle = canvas_data.circles.color2;

        context.beginPath();
        context.arc(canvas_data.circles.x2, canvas_data.circles.y, canvas_data.circles.radius * 1.5, -Math.PI / 2, canvas_data.circles.arc2);
        context.stroke();

        context.beginPath();
        context.arc(canvas_data.circles.x3, canvas_data.circles.y, canvas_data.circles.radius * 1.5, Math.PI, canvas_data.circles.arc2);
        context.stroke();

        context.strokeStyle = canvas_data.circles.color3;

        context.beginPath();
        context.arc(canvas_data.circles.x2, canvas_data.circles.y, canvas_data.circles.radius * 0.5, -Math.PI / 2, canvas_data.circles.arc2);
        context.stroke();

        context.beginPath();
        context.arc(canvas_data.circles.x3, canvas_data.circles.y, canvas_data.circles.radius * 0.5, Math.PI, canvas_data.circles.arc2);
        context.stroke();

    }

    function DrawPaddle(x, y, color){

        context.fillStyle = color;
        context.fillRect(x, y, paddle_data.width, paddle_data.height);

    }

    function DrawBall(){

        context.fillStyle = ball_data.color;

        context.beginPath();
        context.arc(ball_data.position.x, ball_data.position.y, ball_data.size / 2, 0, 2 * Math.PI);
        context.fill();
    }

    function BallMovement(){

        ball_data.position.x += ball_data.speed.x;
        ball_data.position.y += ball_data.speed.y;

        if(ball_data.position.y - ball_data.size / 2 < 0 || ball_data.position.y > canvas_data.size.height - ball_data.size / 2){

            ball_data.speed.y *= -1.05;

        }

        if(ball_data.position.x + ball_data.size / 2 >= player_data.position.x){

            if(ball_data.position.y > player_data.position.y && ball_data.position.y - ball_data.size < player_data.position.y + paddle_data.height){

                ball_data.speed.x *= -1.15;

            }else{

                PointEnemy();

            }

        }
        
        if(ball_data.position.x - ball_data.size / 2 < enemy_data.position.x + paddle_data.width){

            if(ball_data.position.y > enemy_data.position.y && ball_data.position.y - ball_data.size < enemy_data.position.y + paddle_data.height){

                ball_data.speed.x *= -1.15;

            }else{

                PointPlayer();

            }

        }

    }

    function EnemyAI(){

        var enemy_middle = enemy_data.position.y + paddle_data.height / 2;
        var ball_middle = ball_data.position.y + ball_data.size / 2;


        if(enemy_middle - ball_middle > paddle_data.height / 2){

            enemy_data.position.y -= enemy_data.speed.normal;

        }else if(enemy_middle - ball_middle > paddle_data.height / 3){

            enemy_data.position.y -= enemy_data.speed.run;

        }else if(enemy_middle - ball_middle < -paddle_data.height / 2){

            enemy_data.position.y += enemy_data.speed.normal;

        }else if(enemy_middle - ball_middle < -paddle_data.height / 3){

            enemy_data.position.y += enemy_data.speed.run;

        }

        enemy_data.position.y = (enemy_data.position.y < 0) ? 0 : (enemy_data.position.y + paddle_data.height > canvas_data.size.height) ? canvas_data.size.height - paddle_data.height : enemy_data.position.y;
        
    }

    var started_game = false;

    function Game(){

        if(started_game){

            DrawTable();
            DrawPaddle(player_data.position.x, player_data.position.y, player_data.color);
            DrawPaddle(enemy_data.position.x, enemy_data.position.y, enemy_data.color);
            DrawBall();
            
            BallMovement();
            EnemyAI();

        }

    }

    setInterval(Game, 1000/60);

    function PlayerMovement(e){

        var y = e.clientY - canvas.offsetTop;
        
        y = (y < 0) ? 0 : (y + paddle_data.height > canvas_data.size.height) ? canvas_data.size.height - paddle_data.height : y;

        player_data.position.y = y;

    }

    canvas.addEventListener("mousemove", function(e){PlayerMovement(e);});
    canvas.addEventListener("touchmove", function(e){

        var evt = (typeof e.originalEvent === 'undefined') ? e : e.originalEvent;
        var touch = evt.touches[0] || evt.changedTouches[0];
        var y = touch.pageY;

        e = {clientY: y};
        
        PlayerMovement(e);
    
    });
    /*canvas.addEventListener("pointermove", function(e){

        e = {clientY: e.tiltY};
        
        PlayerMovement(e);
    
    });*/

    function PointPlayer(){

        started_game = false;

        var gradient = context.createLinearGradient(0, 0, 0, canvas_data.size.height);
        gradient.addColorStop(0, player_data.color);
        gradient.addColorStop(0.25, canvas_data.background_color);
        gradient.addColorStop(0.75, canvas_data.background_color);
        gradient.addColorStop(1, player_data.color);

        context.fillStyle = gradient;
        context.fillRect(0, 0, canvas_data.size.width, canvas_data.size.height);

        player_data.points += 1;

        context.font = (canvas_data.size.height / 10) + "px Arial";
        context.fillStyle = canvas_data.lines.color;
        context.textAlign = "center";

        if(player_data.points == 10){

            context.fillText("You win!", canvas_data.size.width / 2, canvas_data.size.height / 2);
            setTimeout(rotate("portrait"), 2000);

        }else{

            context.fillText(enemy_data.points + " : " + player_data.points, canvas_data.size.width / 2, canvas_data.size.height / 2);

            Reset();

        }

    }

    function PointEnemy(){

        started_game = false;

        var gradient = context.createLinearGradient(0, 0, 0, canvas_data.size.height);
        gradient.addColorStop(0, enemy_data.color);
        gradient.addColorStop(0.25, canvas_data.background_color);
        gradient.addColorStop(0.75, canvas_data.background_color);
        gradient.addColorStop(1, enemy_data.color);

        context.fillStyle = gradient;
        context.fillRect(0, 0, canvas_data.size.width, canvas_data.size.height);

        enemy_data.points += 1;

        context.font = (canvas_data.size.height / 10) + "px Arial";
        context.fillStyle = canvas_data.lines.color;
        context.textAlign = "center";

        if(enemy_data.points == 10){

            context.fillText("You loose!", canvas_data.size.width / 2, canvas_data.size.height / 2);
            setTimeout(rotate("portrait"), 2000);

        }else{

            context.fillText(enemy_data.points + " : " + player_data.points, canvas_data.size.width / 2, canvas_data.size.height / 2);

            Reset();

        }

    }

    function Reset(){

        setTimeout(function(){

            started_game = true;
            player_data.position.y = enemy_data.position.y = canvas_data.size.height / 2 - paddle_data.height / 2;

            ball_data.position = {x: canvas_data.size.width / 2 - screen.width / 80, y: canvas_data.size.height / 2 - screen.width / 80};
            ball_data.speed = {x: -3, y: -2};

        }, 1500);

    }

    StartGame = function(){

        document.querySelector("button").style.setProperty("display", "none");

        rotate("landscape");

        setTimeout(function(){

            if(screen.width > screen.height){

                canvas.width = canvas_data.size.width = screen.width;
                canvas.height = canvas_data.size.height = screen.height;

            }else{

                canvas.width = canvas_data.size.width = screen.height;
                canvas.height = canvas_data.size.height = screen.width;

            }

            canvas.width = canvas_data.size.width = screen.width;
            canvas.height = canvas_data.size.height = screen.height;

            

            started_game = true;

        }, 1500);
        

    }

});