<?php

    namespace BaseCMS\core;

    /*
     * Handle incoming requests. Parses the request path and determines what
     * templates or output need to be generated.
     *
     */

    use BaseCMS\core\Cartographer as Cartographer;
    use BaseCMS\core\Helpers as h;
     
    class Handler {
    
        private $config;
        private $db;
        private $request;
        private $map_path;
        private $cartographer;
        private $error;
        
        private $template;
        private $skins = array();

        private $next_placeholder = '<!-- __BASE_CMS_INCLUDE_NEXT__ -->';
        
        public $output = '';
        
        function __construct($request, $config, $db, $error) {

            // Just ot be safe, make this uniue per request
            $this->next_placeholder = '<!-- __NEXT_' . spl_object_hash($this) . '__ -->';
        
            $this->config = $config;
            $this->db = $db;
            $this->error = $error;
        
            $request_path = h::explode_path($request->path);
            $mappable_path = array();
            foreach($request_path as $v) {
                if ($v) $mappable_path[] = $v;
            }           
            
            $this->map_path = $mappable_path;
            $this->request = $request;
            $this->map();
            
        }
        
        protected function map() {
        
            // Check to see if it is a static, public file first:
            try{ 
                $f = h::base_include_static($this->request->path, true);
                $this->request->static_headers($f, filemtime($f));
                $this->output = file_get_contents($f);
                $mimetype = h::mime_type($f);
                $this->request->content_type($mimetype);
                return;
            } catch (IncludeException $e) {
                $this->output = '';
            }
            
            $this->cartographer = new Cartographer($this->map_path);
            if (!$this->error) {
                $template = $this->cartographer->find_template();
            } else {
                $httperr = $this->error->httpcode;
                if (!$httperr) $httperr = 500;
                $template = 'error_pages/' . $httperr . '.php';
            }
            $this->template = $template;
            $output = $this->render_template();
            
            // If the postprocess function was defined in the configuration,
            // run it now.
            if (function_exists('postprocess')) $output = postprocess($output);
            $this->output = $output;
            
        }
        
        protected function render_template($template = null) {
        
            // Make these available to the templates
            $request = $this->request;
            $config = $this->config;
            $db = $this->db;
            
            $url_params = $this->cartographer->get_params();
            $url_args = $url_params['positional'];
            $url_kwargs = $url_params['keyword'];
            
            if (!$template) $t = $this->template;
            else $t = $template;
            
            try {
                $f = h::template_include($t, true);
            } catch (IncludeException $e) {
                if (!$config['debug_errors']) h::abort();
                else throw $e;
            }
            
            ob_start();
                include($f);
            $output_data = ob_get_contents();
            ob_end_clean();
            
            $final_output = null;
            if (!empty($this->skins)) {
                foreach ($this->skins as $k => $f) {
                    $o = '';
                    ob_start();
                       include($f);
                        $o = ob_get_contents();
                    ob_end_clean();
                    $this->skins[$k] = $o;
                }
                foreach ($this->skins as $k => $o) {
                    if (!$final_output) {
                        $final_output = $o;
                    } else {
                        $final_output = str_replace($this->next_placeholder, $o, $final_output);
                    }
                }
                $output_data = str_replace($this->next_placeholder, $output_data, $final_output);
            }
            return $output_data;
        }
        
        protected function include_skin($skin_template) {
            if (h::is_absolute_path($skin_template)) 
                $t = h::template_include($skin_template, true);
            else {
                $t = array(dirname($this->template), $skin_template);
                $t = h::implode_path($t);
                $t = h::template_include($t, true);
            }
            $this->skins[] = $t;
        }
        
        protected function include_template($template, $return_path = false) {
            $request = $this->request;
            $config = $this->config;
            $db = $this->db;
            
            $url_params = $this->cartographer->get_params();
            $url_args = $url_params['positional'];
            $url_kwargs = $url_params['keyword'];
            
            $t = h::template_include($template, true);
            if ($return_path) 
                return $t;
            else
                return include($t);
        }
        
        protected function include_next() {
            echo $this->next_placeholder;
        }
        
        protected function abort($errno, $msg) {
            h::abort($errno, $msg);
        }
        
    }
