<?php

    use BaseCMS\core\Helpers as h;
    use BaseCMS\core\Users as u;
    use BaseCMS\core\templating\Fields as Fields;
    
    use BaseCMS\db\RowObject as RowObject;
    
    $user = u::current_user();
    $saved = false;
    $errors = false;
    
    $id = $request->params['id'];
    $view = $request->params['view'];
    
    if (!$id || $id == 'new') {
        $record = new RowObject(array(
            'type_name' => $view,
            'title' => '',
            'author' => $user['id'],
            'live' => 0,
            'draft' => 1,
            'tags' => '',
            'content' => '',
            'live_from' => null,
            'live_until' => null,
            'source' => '',
            'additional_field_data' => '',
            'display_date' => h::mysqlish_now(),
        ), 'records');
    } else {
        $record = $db->get_one('records', array('id' => $id));
    }
    
    if ($request->params['submit']) {
        $record->_update($request->params);        
        $id = $db->save($record);
        if (!$record->id)
            $record = $db->get_one('records', array('id' => $id));
        ?>
        <script type="text/javascript">
            window.top.document.getElementById('menu').contentWindow.location.reload();
        </script>
        <?php
    } else if ($request->params['delete']) {
        $db->delete($record);
        ?>
        <script type="text/javascript">
            window.top.document.getElementById('menu').contentWindow.location.reload();
            window.location = '/admin/edit/';
        </script>
        <?php
    }
    
    $fieldmap = array(
        'type_name' => 'hidden',
        'title' => 'text',
        'author' => 'hidden',
        'live' => 'bool',
        'draft' => 'bool',
        'tags' => 'tags',
        'content' => 'html',
        'live_from' => 'datetime',
        'live_until' => 'datetime',
        'display_date' => 'datetime',
        //'source' => '',
        //'additional_field_data' => '',
    );

    $fields = new Fields($fieldmap, $record, false, $view);
    $fields->form_start();  
    
?>

<div class="alert alert-<?=($saved?'success':'')?><?=($errors?'error':'')?> top-alert"><?php
    if ($saved) echo 'Saved.';
    if ($errors) echo 'There was a problem saving this '.$view.' record. Please check the errors below.';
?></div>
<?php
    $fields->render('title');
    $fields->render('content', 'Entry content');
    $fields->render('tags');
    $fields->render('display_date', 'Publication date', 'The date that will be displayed with this entry.');
?>
<h3>Settings</h3>
<?php
    $fields->render('live', 'Make this entry live', 'Make this entry appear on the public site. This setting will override a "live from" setting.');
    $fields->render('live_from', 'Live from', 'If this is set to a date in the future, this entry will be set to live on this date.');
    $fields->render('live_until', 'Live until', 'If this is set to a date in the future, this entry will be set to be no longer be live on this date.');
    $fields->form_end();
    