<?php

    use BaseCMS\core\Helpers as h;

    $path = $params['path']; // If not cached, Look it up in the user directory, then the public dir?
    $size = $url_args['size'];
    list($w, $h) = explode('x', $size);
    list($w, $h) = array(intval($w), intval($h));
    
    $f = h::get_cached($path);
    $info = '';