function check_achievement(achievement_id, add_achievement = true){

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){

        if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

            var return_value = xmlhttp.responseText 

            if(xmlhttp.responseText == "0" && add_achievement){

                console.log("Achievement "+achievement_id+" added");

                var xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.open("GET", "achievement_data.php?o=set&p="+achievement_id);
                xmlhttp2.send();

            }

            return return_value;

        }

    };

    xmlhttp.open("GET", "achievement_data.php?o=get&p="+achievement_id);
    xmlhttp.send();

}