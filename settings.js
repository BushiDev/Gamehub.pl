var change_name = function(){};
var change_color = function(new_color){};
var change_avatar = function(new_avatar){};

document.addEventListener("DOMContentLoaded", function(){

    var change = function(p, v){

        var xmlhttp = new XMLHttpRequest();

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

        check_achievement(1);
        
    };

    change_color = function(new_color, main = true){

        if(main){

            document.querySelector("html").style.setProperty("--secondary-color", "#"+new_color);
            change("color", new_color);
            check_achievement(3);

        }else{

            change("alternative_color", new_color);
            check_achievement(4);

        }

    }

    var main_image = document.querySelector("img#player_avatar");

    change_avatar = function(new_avatar){

        main_image.src = "images/avatars/" + new_avatar + ".png";
        change("avatar", new_avatar);
        check_achievement(2);

    };

});