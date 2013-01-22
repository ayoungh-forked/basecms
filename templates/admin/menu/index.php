<?php
    
    $this->include_skin('/admin/skins/menu.php');

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
        switch ($view) {
            case 'users':
                $t = 'users.php';
                break;
            case 'pages':
            default:
                $t = 'pages.php';
                break;
        }
    }
?>
<div class="container">
    <?php
    
        $this->include_template("/admin/menu/includes/$t");
    
    ?>
</div>









