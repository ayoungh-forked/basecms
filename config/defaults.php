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
            'username' => 'test',
            'password' => 'test',
            'database' => 'test',
        ),
        
        // Files that can go away, eg., resized images that can be regenerated.
        'temporary_files_dir' => '/tmp/',
        // Files that shouldn't go away, and are uploaded or added by the 
        // user(s).
        'users_files_dir'     => '/tmp/',
        
    );

            
    function postprocess($input) {

        $descriptorspec = array(
           0 => array("pipe", "r"),
           1 => array("pipe", "w"),
           2 => array("pipe", "w")
        );

        $cwd = getcwd();
        $env = array();
        $process = proc_open('scripts/pphtml.py', $descriptorspec, $pipes, $cwd, $env);

        if (is_resource($process)) {
            fwrite($pipes[0], $input);
            fclose($pipes[0]);

            $output = stream_get_contents($pipes[1]);
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            // It is important that you close any pipes before calling
            // proc_close in order to avoid a deadlock
            $return_value = proc_close($process);

            if ($output) 
                return $output;
            else
                return $errors . " ($return_value)";
        }

    }
