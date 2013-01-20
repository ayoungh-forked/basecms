<?php
    
    use BaseCMS\core\Users as u;
    
    $section = $url_kwargs['section'];
    if (!$section)
        $section = 'pages';
        
    $f = null;
        
    switch ($section) {
    
        case 'settings':
            $f = $this->include_template('/admin/_section/settings.php', true);
            break;
        case 'me':
            $f = $this->include_template('/admin/_section/me.php', true);
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
<div id="letterhead" class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <?php
            $this->include_template('/admin/includes/nav.php');  
            
            $section = $url_kwargs['section'];
            if (!$section)
                $section = 'pages';
        
        ?>
    </div>
</div>
<div class="container">
    <div id="sub_body" class="row-fluid">
        <div id="panel_container" class="span12">
            <div class="settings-pane well">
            <?php
                include($f);
            ?>
            </div>
        </div>
    </div>
</div>