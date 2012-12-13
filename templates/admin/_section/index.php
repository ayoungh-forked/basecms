<?php
    
    use BaseCMS\core\Users as u;
    
    $section = $url_kwargs['section'];
    if (!$section)
        $section = 'pages';
    
    switch ($section) {
    
        case 'settings':
            $f = $this->include_template('/admin/_section/settings.php', false);
            break;
            
        default:
            $f = $this->include_template('/admin/index.php', true);
            include($f);
            return;
    
    }

    $this->include_skin('/admin/skin.php');
    $this->include_template('/admin/includes/authenticate.php');
    
    if (!u::logged_in()) {
        return;
    }
?>
<div id="letterhead">
    <div>
        <?php
            $this->include_template('/admin/includes/nav.php');  
            
            $section = $url_kwargs['section'];
            if (!$section)
                $section = 'pages';
        
        ?>
    </div>
</div>
<?php

    include($f);