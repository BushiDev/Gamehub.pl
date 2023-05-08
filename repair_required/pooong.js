var StartGame;

document.addEventListener("DOMContentLoaded", function(){

    var game_is_running = false;

    var canvas_data = {

        orientation: 0,
        width: 0,
        height: 0,
        background: "red",
        lines: {

            width: 0,
            height: 0,
            color: "#fff"

        }

    };

    var canvas = document.querySelector("canvas");
    var context = canvas.getContext("2d");

    function Check_Orientation(){

        if(window.innerWidth > window.innerHeight){

            canvas_data.orientation = 1;
            rotate("landscape");

            canvas_data.lines.width = canvas_data.width / 100;
            canvas_data.lines.height = canvas_data.height / 40;

        }else{

            canvas_data.orientation = 2;
            rotate("portrait");

            canvas_data.lines.width = canvas_data.width / 40;
            canvas_data.lines.height = canvas_data.height / 100;

        }

        canvas.width = canvas_data.width = window.innerWidth;
        canvas.height = canvas_data.height = window.innerHeight;

    }

    function Draw_Table(){

        context.fillStyle = canvas_data.background;
        context.fillRect(0, 0, canvas_data.width, canvas_data.height);

        for(let i = canvas_data.lines.height / 2; i < canvas_data.height; i += canvas_data.lines.height){

            context.fillStyle = canvas_data.lines.color;
            context.fillRect(canvas_data.width / 2 - canvas_data.lines.width / 2, i, canvas_data.lines.width, canvas_data.lines.height);



        }

    }

    function Game_Loop(){

        Draw_Table();

    }

    StartGame = function(){

        Check_Orientation();

        Draw_Table();

    };

});