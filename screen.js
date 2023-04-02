var rotate = function(orientation){

    let de = document.documentElement;
    
    if(de.requestFullscreen){

        de.requestFullscreen();
        
    }else if(de.mozRequestFullscreen){

        de.mozRequestFullscreen();
        
    }else if(de.webkitRequestFullscreen){

        de.webkitRequestFullscreen();
        
    }else if(de.msRequestFullscreen){

        de.msRequestFullscreen();
        
    }

    screen.orientation.lock(orientation);

}