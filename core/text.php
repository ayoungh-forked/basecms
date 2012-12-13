<?php

    namespace BaseCMS\core;
    
    class Text {
        
        static function camelcase_to_snakecase($str) {
            $str = preg_replace_callback('/[a-z][A-Z]/',  create_function('$match', 'return $match[0][0] . "_" . strtolower($match[0][1]);'),  $str);
            return strtolower($str);
        }
    
        static function snakecase_to_titlecase($txt) {
            return ucwords(str_replace('_', '', $txt));
        }
    
    }