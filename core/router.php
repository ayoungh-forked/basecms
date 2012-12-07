<?php

    namespace BaseCMS\core;
    use BaseCMS\core\Helpers as h;
    
    class Router {
    
        private $route_map;
        private $route_path;
        private $mapped_route;
        private $keyword_params = array();
        private $positional_params = array();
    
        function __construct($route_path) {
            $f = h::base_include('config/routes.php', true);
            include($f);
            $this->route_map = $ROUTE_MAP;
            foreach ($this->route_map as $k => $v) {
                $this->route_map[$k] = array(array_filter(explode('/', $v)), $v);
            }
            $this->route_path = $route_path;
            $this->map_route();
        }
        
        private function map_route() {
            $valid_routes = $this->route_map;
            $star = array();
            $rcount = array();
            $count = 0;
            
            foreach ($this->route_path as $k => $v) {
                $k = $k+1;
                foreach ($valid_routes as $mk => $mv) {
                    if (!$star[$mk] && !h::starts_with($mv[0][$k], ':') && $mv[0][$k] != '**') {
                        if ($v != $mv[0][$k]) {
                            unset($valid_routes[$mk]);
                        }
                    } else if ($mv[0][$k] == '**') {
                        $star[$mk] = true;
                    }
                }
                $count++;
            }
            
            foreach ($valid_routes as $k => $v) {
                $parts = $v[0];
                $parts = array_filter($parts, array($this, 'partfilter'));
                $pcount = count($parts);
                
                if ($count < $pcount) {
                    unset($valid_routes[$k]);
                } else if ($count > $pcount && !in_array('*', $v[0])) {
                    unset($valid_routes[$k]);
                }
            }
            $this->mapped_route = array_shift($valid_routes);
        }
            
        protected function partfilter ($v) {
            return ($v != '*');
        }
        
        function find_template() {
            $request_route = array_values($this->route_path);
            $template_path = array();
            
            if (!empty($this->mapped_route)) {
                foreach ($this->mapped_route[0] as $k => $v) {
                    if (!h::starts_with($v, ':')) {
                        if ($v == '*') {
                            $this->positional_params = $request_route;
                            break;
                        } else {
                            $template_path[] = $v;
                            array_shift($request_route);
                        }
                    } else {
                        $uk = substr($v, 1, strlen($v));
                        $template_path[] = '_' . $uk;
                        $this->keyword_params[$uk] = array_shift($request_route);
                    }
                }
            } else {
                foreach ($request_route as $k => $v) {
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
    