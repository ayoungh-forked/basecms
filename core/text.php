<?php

    namespace BaseCMS\core;
    
    class Text {
    
        static function snakecase_to_titlecase($txt) {
            return ucwords(str_replace(' ', '_', $txt));
        }
    
    }