<?php
    namespace BaseCMS\core;

    /*
     * Static class for assorted utility functions.
     *
     */
     
    class AbortException extends \Exception {
    
        public $httpcode;
    
        function __construct($message, $httpcode = 404, $code = 0, Exception $previous = null) {
            
            $this->httpcode = $httpcode;
            parent::__construct($message, $code, $previous);
            
        }
            
        
    }
     
    class IncludeException extends \Exception {
    
        public $httpcode;
    
        function __construct($message, $httpcode = 500, $code = 0, Exception $previous = null) {
            
            $this->httpcode = $httpcode;
            parent::__construct($message, $code, $previous);
            
        }
        
    }

    class Helpers {
    
        static function base_include($f, $return_path = false, $prep = '', $ext = '.php') {
            if (!self::ends_with($f, '.php')) $f = $f . $ext;

            if ($f) $f = $prep . $f;
            $sitepath = SITE_DIR . $f;
            $rootpath = ROOT_DIR . $f;
            
            if (defined('SITE_DIR') && is_readable($sitepath) && !is_dir($sitepath)) {
                if (!$return_path) include($sitepath);
                else return $sitepath;
            } else if (is_readable($rootpath) && !is_dir($rootpath)) {
                if (!$return_path) include($rootpath);
                else return $rootpath;
            } else {
                throw new IncludeException('Could not load file with base_include:' . $f);
            }
        }
    
        static function base_include_static($f, $return_path = false) {
            $f = self::base_include($f, true, 'public/', '');
            if (!$return_path) {
                return file_get_contents($f);
            } else {
                return $f;
            }
        }
    
        static function template_include($f, $return_path = false) {
            return self::base_include($f, $return_path, 'templates/');
        }
        
        static function mime_type($path) {
            $fext = explode('.', $path);
            $ext = array_pop($fext);
            $guess = self::guess_type($ext);
            // Let the correct web types take priority based on extension, since
            // finfo_file is buggy and returning text/x-c for CSS files.
            if ($guess) return $guess; 
            
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimetype = finfo_file($finfo, $path);
            
            if (self::starts_with($mimetype, 'image/')) {
                // Let imagemagick try to be more specific
                $guess = self::image_type($path);
                if ($guess) $mimetype = $guess;
            }
            return $mimetype;
        }
        
        static function guess_type($ext) {
            switch ($ext) {
                case 'css':
                    return 'text/css';
                case 'js':
                    return 'text/javascript'; // techinally incorrect, practically required
                case 'xml':
                    return 'text/xml'; // technically incorrect, practically required
                case 'txt':
                    return 'text/plain';
                default:
                    return null;
            }
        }
        
        static function image_type($path) {
            if (function_exists('getimagesize')) {
                list($width, $height, $type) = getimagesize($path);
                return $type;
            }
        }
        
        static function abort($errno = 404, $msg = '') {
            throw new AbortException($msg, $errno);
        }
        
        static function is_absolute_path($str) {
            return self::starts_with($str, DIRECTORY_SEPARATOR);
        }
        
        static function implode_path($array) {
            return implode(DIRECTORY_SEPARATOR, $array);
        }
        
        static function explode_path($string) {
            return explode(DIRECTORY_SEPARATOR, $string);
        }
        
        static function starts_with($haystack, $needle) {
            return !strncmp($haystack, $needle, strlen($needle));
        }
        
        static function ends_with($haystack, $needle) {
            $length = strlen($needle);
            if ($length == 0) {
                return true;
            }
            return (substr($haystack, -$length) === $needle);
        }
        
        static function mysqlish_now() {
            return date('Y-m-d H:i:s');
        }
        
        static function filter($array, $func = null) {
            $narry = array();
            if ($func) 
                $array = array_filter($array, $func);
            else
                $array = array_filter($array);
            foreach ($array as $v) {
                $narry[] = $v;
            }
            return $narry;
        }
    
    }
