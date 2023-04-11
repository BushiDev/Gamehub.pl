var change_name = function(){};
var change_color = function(new_color){};
var change_avatar = function(new_avatar){};

document.addEventListener("DOMContentLoaded", function(){

    var xmlhttp = new XMLHttpRequest();

    var change = function(p, v){

        xmlhttp.onreadystatechange = function(){

            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

                console.log(xmlhttp.responseText);

            }

        };

        xmlhttp.open("GET", "user_data.php?o=set&p="+p+"&v="+v);
        xmlhttp.send();

    }

    change_name = function(){

        var new_name = document.querySelector("input#show_name").value;
        change("show_name", new_name);
        
    };

    change_color = function(new_color, main = true){

        if(main){

            document.querySelector("html").style.setProperty("--secondary-color", "#"+new_color);
            change("color", new_color);

        }else{

            change("alternative_color", new_color);

        }

    }

    var main_image = document.querySelector("img#player_avatar");

    change_avatar = function(new_avatar){

        main_image.src = "images/avatars/" + new_avatar + ".png";
        change("avatar", new_avatar);

    };

});