"use strict";

var h = {

    /*
     * Cookie functions courtesy Scott Andrew and Peter-Paul Koch
     * http://www.quirksmode.org/js/cookies.html
     *
     */
     
    set_cookie: function (name, value, days) {
        
        var expires;
        
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires="+date.toGMTString();
        } else
            expires = "";
            
        document.cookie = name+"="+value+expires+"; path=/";
        
    },
    
    read_cookie: function (name) {
        
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        
        for(var i=0; i < ca.length; i++) {
            
            var c = ca[i];
            while (c.charAt(0) == ' ') 
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) 
                return c.substring(nameEQ.length, c.length);
                
        }
        
        return null;
        
    },

    clear_cookie: function (name) {
        h.set_cookie(name, "", -1);
    },
    
    // Unifying method for fullscreen functionality
    requestFullscreen: function(element) {
        if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
        } else {
            if (element.cancelFullScreen) {
                element.cancelFullScreen();
            } else if (element.mozCancelFullScreen) {
                element.mozCancelFullScreen();
            } else if (element.webkitCancelFullScreen) {
                element.webkitCancelFullScreen();
            }
        }
    }
    
};

$(document).on('mozfullscreenchange webkitfullscreenchange fullscreenchange', function() {
    $(document.fullscreenElement  || document.mozFullScreenElement || document.webkitFullscreenElement).toggleClass('fullscreen');  
});