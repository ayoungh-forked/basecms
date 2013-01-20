<?php

    use BaseCMS\core\Helpers as h;
    use BaseCMS\core\Users as u;
    use BaseCMS\core\templating\Fields as Fields;
    
    use BaseCMS\db\RowObject as RowObject;
    
    $user = u::current_user();
    
    $id = $request->params['id'];
    $view = $request->params['view'];
    
    if (!$id || $id == 'new') {
        $record = new RowObject(array(
            'admin' => 0,
            'developer' => 0,
            'role' => 0,
            'username' => '',
            'password_hash' => '',
            'real_name' => '',
        ), 'users');
    } else {
        $record = $db->get_one('users', array('id' => $id));
    }
    
    $password_description = null;
    $saved = false;
    $errors = false;
    
    if ($request->params['submit']) {
    
        if (in_array('password', array_keys($request->params))) {
            if ($request->params['password'] && $request->params['password'] == $request->params['password_confirm']) {
                $request->params['password_hash'] = u::password_hash($request->params['password']);
            } else {
                // This is just the fallback in case they don't have javascript!
                $errors = true;
                $password_description = '<div class="alert alert-error">The passwords you entered do not match. Please try again.</div>';
            }
        }
        
        $record->_update($request->params);
        if (!$errors) {
            $id = $db->save($record);
            $saved = true;
        }
        
        if (!$record->id)
            $record = $db->get_one('users', array('id' => $id));
            
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
        'admin' => 'bool',
        'developer' => 'bool',
        //'role' => '',
        'username' => 'text',
        'real_name' => 'text',
        'password' => 'password:new',
    );

    $fields = new Fields($fieldmap, $record, false, $view);
    $fields->form_start();  
    
?>
<h2>Edit user</h2>
<div class="alert-<?=($saved?'success':'')?><?=($errors?'error':'')?> top-alert"><?php
    if ($saved) echo 'Saved.';
    if ($errors) echo 'There was a problem saving this user record. Please check the errors below.';
?></div>
<?php
    $fields->render('username');
    $fields->render('real_name');
    $fields->render('password', 'Password', $password_description);
    $fields->render('admin', 'Administrator');
    $fields->render('developer');
    
    $fields->form_end();
?>