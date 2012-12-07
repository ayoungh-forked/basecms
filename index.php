<?php
    
    define('ROOT_DIR', dirname(__FILE__) . '/');
    
    require('core/setup.php');
    require('config/defaults.php');
    
    use BaseCMS\core\Request as Request;
    use BaseCMS\core\Handler as Handler;
    use BaseCMS\core\Helpers as h;
    use BaseCMS\db\Connector as DBConnector;
    
    // The proper procedure for overriding the entries in $DEFAULT_SITE_SETTINGS
    // is to set (or include) your own $SITE_SETTINGS before then including this
    // file.
    if ($SITE_SETTINGS) {
        $SITE_SETTINGS = array_merge($DEFAULT_SITE_SETTINGS, $SITE_SETTINGS);
    } else {
        $SITE_SETTINGS = $DEFAULT_SITE_SETTINGS;
    }
    
    if ($SITE_SETTINGS['debug_errors']) {
        ini_set('display_errors', 'stdout');
    } else {
        ini_set('display_errors', 'stderr');
    }
    
    if ($SITE_SETTINGS['base_directory']) {
        define('SITE_DIR', $SITE_SETTINGS['SITE_DIR']);
    }
    
    if ($SITE_SETTINGS['database']) {
        $db = new DBConnector($SITE_SETTINGS['database']);
    }
    
    $request = new Request();
    $output = '';

    try {
    
        $handler = new Handler($request, $SITE_SETTINGS, $db);
        $output = $handler->output;
        echo $output;
        
    } catch (Exception $e) {
    
        if ($SITE_SETTINGS['debug_errors']) {
        
            if ($e->httpcode) $request->response_header($e->httpcode);
            else $request->response_header(500);
            $request->content_type('text/plain');
            echo $e;
            
        } else {
        
            try {
            
                $error_handler = new Handler($request, $SITE_SETTINGS, $db, $e);
                $output = $error_handler->output;
                
            } catch (Exception $e) {
            
                // Last ditch effort at a clean error message.
                $request->response_header(500);
                $request->content_type('text/plain;');
                $ouput = 'Internal server error';
                
            }
            
            if ($output) echo $output;
            
        }
        
    }
