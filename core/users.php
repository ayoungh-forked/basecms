<?php

    namespace BaseCMS\core;
    
    class Users {
    
        static function logged_in() {
            if (!self::session_is_active())
                session_start();
            if ($_SESSION['logged_in']) {
                return true;
            } else {
                return false;
            }
        }
        
        static function log_in($user = null) {
            if (!self::session_is_active())
                session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $user;
        }
        
        static function log_out() {
            if (!self::session_is_active())
                session_start();
            $_SESSION['logged_in'] = false;
            session_destroy();
        }
        
        static function current_user() {
            if (!self::session_is_active())
                session_start();
            return $_SESSION['user'];
        }
        
        static function session_is_active() {
            return $_SESSION['ACTIVE'];
        }
        
        static function password_hash($input, $salt = null) {
        
            if (!$salt) {
                $salt = '';
                $data = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                for ($i=0; $i < 22; $i++) {
                    $salt .= $data[rand(0, 63)];
                }
            }
            
            $blowfish_salt = '$2a$10$' . $salt . '$';
            $hash = crypt($input, $blowfish_salt);
            return $salt . $hash;
            
        }
        
        static function password_check($input, $stored) {
        
            $s = substr($stored, 0, 22);
            return (self::password_hash($input, $s) == $stored);
        
        }
    
    
    }

    