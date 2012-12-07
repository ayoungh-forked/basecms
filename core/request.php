<?php

    namespace BaseCMS\core;
    
    /*
     * Class for objectifying individual requests. Combines $_GET and $_POST
     * into a single $params property for convenience, and creates some
     * syntactic sugar for some of the more useful properties in $_SERVER.
     *
     */
    class Request {
        public $method;
        public $protocol;
        public $path;
        public $params;
        
        public $user_agent;
        public $address;
        public $port;
        
        public $time;
        
        function __construct() {
            $urlstring = $_GET['_u'];    
            $this->path = '/'.$urlstring;
            
            $params = array();
            $params = array_replace($params, $_GET);
            unset($params['_u']);
            $params = array_replace($params, $_POST);
            $this->params = $params;
            
            $this->address = $_SERVER["REMOTE_ADDR"];
            $this->port = $_SERVER["REMOTE_PORT"];
            
            $this->user_agent = $_SERVER["HTTP_USER_AGENT"];
            
            $this->protocol = $_SERVER["SERVER_PROTOCOL"];
            $this->method = $_SERVER["REQUEST_METHOD"];
            
            $this->time = $_SERVER["REQUEST_TIME"];
        }
        
        function content_type($content_type) {
            header('Content-type: ' . $content_type . '');
        }
        
        function response_header($http_no) {
        
            switch ($http_no) {
            
                case 404:
                    $e = 'Not found';
                    break;
                    
                case 500:
                    $e = 'Internal server error';
                    break;
                    
                default:
                    $e = 'msg here';
            
            }
            
            header($_SERVER["SERVER_PROTOCOL"] . " " . $http_no . " " . $e);
        
        }
        
        function redirect($location) {
            header('Location: ' . $location);
        }
        
        // Lifted whole from Rich Bradshaw: http://stackoverflow.com/questions/2000715/answering-http-if-modified-since-and-http-if-none-match-in-php
        function static_headers($file, $timestamp) {
            $gmt_mtime = gmdate('r', $timestamp);
            header('ETag: "'.md5($timestamp.$file).'"');
            header('Last-Modified: '.$gmt_mtime);
            header('Cache-Control: public');
        
            if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) || isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
                if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $gmt_mtime || str_replace('"', '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) == md5($timestamp.$file)) {
                    header('HTTP/1.1 304 Not Modified');
                    exit();
                }
            }
        }
    }
