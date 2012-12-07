<?php
    
    $section = $url_kwargs['section'];
    if (!$section)
        $section = 'pages';
    
    switch ($section) {
    
        default:
            $f = $this->include_template('/admin/index.php', true);
            include($f);
        
    
    }