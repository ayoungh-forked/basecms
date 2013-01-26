<?php

    namespace BaseCMS\core;
    use BaseCMS\core\Helpers as h;


    class Cache {

        private $basedir;
        private $cache_for;

        function __construct($basedir $cache_for = -1) {
            $this->basedir = $basedir;
            $this->cache_for = $cache_for;
        }

        protected function get_valid_cachefile($refpath, $refversion) {
            $fname = md5($refpath) . '.' . md5($refversion) . '.cache';
            $path = array($this->basedir, $fname);
            $path = h::implode_path($path);
            // check that the path exists and isn't out of date
            // if it is invalid or out of date, delete it and make a new one.
            return $path;
        }

        protected function write_cachefile($refpath, $refversion, $content) {
            $cachefile = $this->get_valid_cachefile($refpath, $refversion);
            // write content to file
        }

        protected function read_cachefile($refpath, $refversion) {
            $cachefile = $this->get_valid_cachefile($refpath, $refversion);
            
        }

        public function is_cached($refpath, $refversion) {
		// $request->
        }

        public function clear() {

        }


    }
