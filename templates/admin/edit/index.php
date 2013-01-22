<?php
    $this->include_skin('/admin/skins/edit.php');
?>
<div class="container">
    <?php
    
        $view = $request->params['view'];
        $t = null;
        
        $result = $db->get('record_types');
        $record_types = array();
        foreach ($result as $row) {
            $record_types[] = $row->name;
            if ($view == $row->name)
                $t = "records.php";
        }
        
        if (!$t) {
            switch($view) {
                case 'users':
                    $t = 'users.php';
                    break;
                case 'pages':
                    $t = 'pages.php';
                    break;
                default:
                    $t = null;
            }
        }
        
        if ($t)
            $this->include_template("/admin/edit/includes/$t");
        else {
    ?>

    <div class="default_message hero-unit">
        <h3>Welcome back to Base</h3>
        <p>
            Use the menu on the left to get started.
        </p>
    </div>
    
    <?php
        }
    ?>
</div>