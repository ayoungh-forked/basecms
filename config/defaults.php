<?php
    
    define('DATABASE_ENGINE', 'mysql');

    $DEFAULT_SITE_SETTINGS = array(
        
        // Base directory containing additional site files.
        'site_directory'    => '/srv/ldep/iont/sites/dev.iont.de/',
    
        // If true, outputs errors based on your php.ini configuration.
        // If false, errors are caught and the 500 error page is displayed
        // instead.
        'debug_errors'      => true,
        // When 'debug_errors' is false, you can specify an email address here
        // to send errors to.
        'error_email'       => 'ops@iont.de',
        // If greater than 0, this is the number of seconds the server will wait
        // before re-sending any identical error messages (in the meantime, all
        // other identical errors will be bit-bucketed).
        'error_resend_threshold'  => 10 * 60,
        
        // Database setup information.
        'database' => array(
            'engine'   => 'mysql',
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '2ust1N_ttc',
            'database' => 'mschuller',
        ),
        
        // Files that can go away, eg., resized images that can be regenerated.
        'temporary_files_dir' => '/tmp/',
        // Files that shouldn't go away, and are uploaded or added by the 
        // user(s).
        'users_files_dir'     => '/tmp/',
        
    );
