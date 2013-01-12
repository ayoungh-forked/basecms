<?php

    namespace BaseCMS\core;
    use BaseCMS\core\Helpers as h;
    
    class Cartographer {
    
        private $url_map;
        private $map_path;
        private $mapped_path;
        private $keyword_params = array();
        private $positional_params = array();
    
        function __construct($map_path) {
            $f = h::base_include('config/map.php', true);
            include($f);
            $this->url_map = $URL_MAP;
            foreach ($this-url_map as $k => $v) {
                $this->url_map[$k] = array(array_filter(explode('/', $v)), $v);
            }
            $this->map_path = $map_path;
            $this->map();
        }
        
        private function map() {
            $valid_paths = $this->url_map;
            $star = array();
            $rcount = array();
            $count = 0;
            
            foreach ($this->map_path as $k => $v) {
                $k = $k+1;
                foreach ($valid_paths as $mk => $mv) {
                    $mv = explode('/', $mv);
                    if (!$star[$mk] && !h::starts_with($mv[0][$k], ':') && $mv[0][$k] != '**') {
                        if ($v != $mv[0][$k]) {
                            unset($valid_paths[$mk]);
                        }
                    } else if ($mv[0][$k] == '**') {
                        $star[$mk] = true;
                    }
                }
                $count++;
            }
            
            foreach ($valid_paths as $k => $v) {
                $parts = $v[0];
                $parts = array_filter($parts, array($this, 'partfilter'));
                $pcount = count($parts);
                
                if ($count < $pcount) {
                    unset($valid_paths[$k]);
                } else if ($count > $pcount && !in_array('*', $v[0])) {
                    unset($valid_paths[$k]);
                }
            }
            $this->mapped_path = array_shift($valid_paths);
        }
            
        protected function partfilter ($v) {
            return ($v != '*');
        }
        
        function find_template() {
            $request_path = array_values($this->map_path);
            $template_path = array();
            
            if (!empty($this->mapped_path)) {
                foreach ($this->mapped_path[0] as $k => $v) {
                    if (!h::starts_with($v, ':')) {
                        if ($v == '*') {
                            $this->positional_params = $request_path;
                            break;
                        } else {
                            $template_path[] = $v;
                            array_shift($request_path);
                        }
                    } else {
                        $uk = substr($v, 1, strlen($v));
                        $template_path[] = '_' . $uk;
                        $this->keyword_params[$uk] = array_shift($request_path);
                    }
                }
            } else {
                foreach ($request_path as $k => $v) {
                    $template_path[] = $v;
                }
            }
            
            $template_path = h::implode_path($template_path) . '/index.php';            
            return $template_path;        
        }
        
        function get_params() {
            return array(
                'positional' => $this->positional_params,
                'keyword' => $this->keyword_params,
            );
        }
        
    }
    
