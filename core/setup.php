<?php

    /*
     * Setup the execution environment.
     * Sets the autoloader and error handling behaviour.
     *
     */
    
    include('text.php'); // Handy string manipulation functions

    function base_autoloader($classname) {
        
        $pathlist = explode('\\', $classname);
        
        $maxkey = max(array_keys($pathlist));
        $pathlist[$maxkey] = BaseCMS\core\Text::camelcase_to_snakecase($pathlist[$maxkey]);
        $pathlist[$maxkey] .= '.php';
        foreach ($pathlist as $k => $p) {
            if ($k != $maxkey) $pathlist[$k] = strtolower($p);
        }
	$base_path = ROOT_DIR . implode('/', array_slice($pathlist, 1, count($pathlist)));
        
        /*
         * Check the site directory for a local version of the class in 
         * question.
         */
        if (defined('SITE_DIR')) {
            $site_path = SITE_DIR . implode('/', $pathlist);
            if (is_readable($site_path)) {
                include($site_path);
                return;
            }
        }
        
        /*
         * Load the core version.
         */
        if (is_readable($base_path)) {
            include($base_path);
            return;
        }
    
    }

    function base_error_handler($errlevel, $errstr, $f, $line) {
        if ($errlevel > 8) throw new ErrorException($errstr, 0, $errlevel, $f, $line);
    }

    function base_exception_handler($e) {
        $msg = $e->getMessage();   
        echo "Uncaught Exception\n";
        echo $msg;
        print_r($e->getTrace());
    }

    spl_autoload_register('base_autoloader', true, true);
    set_error_handler('base_error_handler');
    set_exception_handler('base_exception_handler');

    ini_set('session.name', 'baseID');
