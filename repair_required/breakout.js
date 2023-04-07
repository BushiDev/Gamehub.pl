class Brick{

  static width = window.innerWidth / 15;
  static height = window.innerHeight / 25;
  static margin = this.width / this.height;

  constructor(pos, color = "#c009a7"){

    this.position = pos;
    this.color = color;

  }

}

class Ball{

  static size = 3;
  static speed = 5;

  constructor(pos, color = "#fff"){

    this.position = pos;
    this.color = color;

  }

}

class Player{

  static width = window.innerWidth / 8  ;
  static height = window.innerHeight / 75;

  constructor(pos, color = "#0ff"){

    this.position = pos;
    this.color = color;

  }

}

var bricks = [];
var rows = 0;
var main_color = "#0ff";
document.addEventListener("DOMContentLoaded", function(){

    var canvas = document.querySelector("canvas");
    var context = canvas.getContext("2d");

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    function setup_bricks(){

      for(var i = Brick.margin; i < window.innerHeight / 7 * 3 - Brick.height; i += Brick.height){

        rows++;
        i += Brick.margin;
  
      }
  
      var current_row = rows;
  
      var start_bricks = 0;
      var bricks_width = Brick.margin;
  
      for(var j = Brick.margin; j < window.innerWidth - Brick.width; j += Brick.width){
  
        bricks_width += Brick.width;
        bricks_width += Brick.margin;
  
        j += Brick.margin;
  
      }
  
      if(bricks_width < window.innerWidth){
  
        start_bricks = window.innerWidth - bricks_width;
        start_bricks /= 2;
  
      }
  
      for(var i = Brick.margin + start_bricks; i < window.innerHeight / 7 * 3 - Brick.height; i += Brick.height){
  
          var color = hexToHSL(main_color);
          color.s = hexToHSL(main_color).s * (current_row - 1) / rows;
          //color.l = hexToHSL(main_color).l / rows * current_row;
  
          for(var j = Brick.margin + start_bricks; j < window.innerWidth - Brick.width; j += Brick.width){
  
            bricks.push(new Brick({x: j, y: i}, "hsl("+color.h+", "+color.s+"%, "+color.l+"%)"));
  
            j += Brick.margin;
  
          }
  
          current_row--;
  
          i += Brick.margin;
  
      }

    }

    function draw_background(){

      context.fillStyle = "#000";
      context.fillRect(0, 0, window.innerWidth, window.innerHeight);

    }

    function draw_bricks(){
  
      bricks.forEach(brick => {
  
        if(brick != null){

          context.fillStyle = brick.color;
          context.fillRect(brick.position.x, brick.position.y, Brick.width, Brick.height);

        }
  
      });

    }

    function draw_player(){

      player = new Player({x: window.innerWidth / 2 - Player.width / 2, y: window.innerHeight - Player.height * 3});

      context.fillStyle = player.color;
      context.fillRect(player.position.x, player.position.y, Player.width, Player.height);

    }

    function draw_ball(){

      

    }    

    setup_bricks();

    function game(){

      draw_background();
      draw_bricks();
      draw_player();

    }

    setInterval(game, 1000/60);

});