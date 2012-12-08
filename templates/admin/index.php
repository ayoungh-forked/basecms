<?php
    use BaseCMS\core\Users as u;

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
<div id="sub_body">
    <div id="panel_container">
        <iframe id="menu" name="menu" src="/admin/menu/?view=<?=($section ? $section : '')?>">
            Your browser does not support iframes. <a href="/admin/menu/?view=<?=($section ? $section : '')?>" target="menu">Click here to open this frame in a new window.</a>
        </iframe>
        <iframe id="edit_pane" name="edit_pane" src="/admin/edit/">
            Your browser does not support iframes. Please use the link above to navigate the menu.
        </iframe>
    </div>
</div>