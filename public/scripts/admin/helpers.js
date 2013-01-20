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

$(document).ready(function() {
    
    /*
     * Hotkeys!
     * 
     */
    function buttonTrigger($btn, e) {
        e.preventDefault();
        // Check to see if there is a menu open with an 'add' button first.
        var $btn = $(window.top.frames[0].document.getElementsByClassName('btn add').item(0)) || $('.btn.add');
        if ($btn.length) {
            if ($btn.get(0).tagName == 'A' && $btn.attr('href'))
                window.top.open($btn.attr('href'), $btn.attr('target') || window.top.name);
            else
                $btn.click();
        }
    }
    
    if (!window.top.keypress) 
        window.top.keypress = function(e) {
            if (!(e.ctrlKey || e.metaKey)) return;
            switch (e.charCode) {
                case 110:
                    // CTRL-N: New
                    var $btn = $(window.top.frames[0].document.getElementsByClassName('btn add').item(0)) || $('.btn.add');
                    buttonTrigger($btn, e);
                    break;
                case 101:
                    // CTRL-S: Save
                    var $btn = $(window.top.frames[1].document.getElementsByClassName('btn save').item(0)) || $('.btn.save');
                    buttonTrigger($btn, e);
                    break;
                    break;
            }
        };
    
    $('body').on('keypress', window.top.keypress);
    
});