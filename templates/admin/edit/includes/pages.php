<?php

    use BaseCMS\core\Users as u;
    use BaseCMS\core\templating\Fields as Fields;
    
    use BaseCMS\db\RowObject as RowObject;
    
    $user = u::current_user();
    $saved = false;
    $errors = false;

    $id = $request->params['id'];
    if (!$id || $id == 'new') {
        $record = new RowObject(array(
            'title' => '',
            'url_path' => '',
            'live' => 0,
            'template' => null,
            'description' => '',
            'keywords' => '',
            'tags' => '',
            'content' => '',
            'styles' => '',
            'scripts' => '',
            'developer_lock' => 0,
            'admin_lock' => 0,
            'live_from' => null,
            'live_until' => null,
            'redirect' => ''
        ), 'pages');
    } else {
        $record = $db->get_one('pages', array('id' => $id));
    }
    
    if ($request->params['submit']) {
        $record->_update($request->params);        
        $id = $db->save($record);
        $saved = true;
        if (!$record->id)
            $record = $db->get_one('pages', array('id' => $id));
        ?>
        <script type="text/javascript">
            window.top.document.getElementById('menu').contentWindow.location.reload();
        </script>
        <?php
    } else if ($request->params['delete']) {
        function delete_with_subrecords($record, $db) {
            $child_records = $db->get('pages', array('parent_id' => $record->id));
            $db->delete($record);
            foreach($child_records as $record) {
                delete_with_subrecords($record, $db);
                $db->delete($record);
            }
        }
        delete_with_subrecords($record, $db);
        ?>
        <script type="text/javascript">
            window.top.document.getElementById('menu').contentWindow.location.reload();
            window.location = '/admin/edit/';
        </script>
        <?php
    }
    
    $fieldmap = array(
        'title' => 'text',
        'url_path' => 'url:path_fragment',
        'live' => 'bool',
        'template' => 'template',
        'description' => 'textarea',
        'keywords' => 'text',
        'tags' => 'tags',
        'content' => 'html',
        'styles' => 'css',
        'scripts' => 'js',
        'developer_lock' => 'bool',
        'admin_lock' => 'bool',
        'live_from' => 'datetime',
        'live_until' => 'datetime',
        'redirect' => 'url'
    );

    $fields = new Fields($fieldmap, $record, false);
    $fields->form_start();  
?>

<div class="alert alert-<?=($saved?'success':'')?><?=($errors?'error':'')?> top-alert"><?php
    if ($saved) echo 'Saved.';
    if ($errors) echo 'There was a problem saving this page record. Please check the errors below.';
?></div>
<?php
    $fields->render('title');
    $fields->render('url_path', 'Path', 'How you want this page to appear in the URL. Eg.: <em>sample-page</em>');
    $fields->render('template', 'Select a template');
    $fields->render('content', 'Page content', 'The main content for this page. How this is displayed will depend on the settings for the template being used.');
    $fields->render('tags');
?>
<h3>Page settings</h3>
<?php
    $fields->render('live', 'Make this page live', 'Make this page appear on the public site. This setting will override a "live from" setting.');
    $fields->render('live_from', 'Live from', 'If this is set to a date in the future, the page will be set to live on this date.');
    $fields->render('live_until', 'Live until', 'If this is set to a date in the future, the page will be set to be no longer be live on this date.');
    if ($user['admin'])
        $fields->render('admin_lock', 'Administrator lock');
    if ($user['developer'])
        $fields->render('developer_lock', 'Developer lock');
    $fields->render('redirect', 'Redirect URL', 'To redirect to another page instead of displaying this one, add the URL you want to redirect to here.');
    $fields->render('keywords', 'Page keywords', 'A few relevant terms or subjects related to this page\'s content.');
    $fields->render('description', 'Page description', 'A description of this page\'s content for the page metadata, to be used by web crawlers and search engines.');
    if ($settings['styles_fields'])
        $fields->render('styles', 'Styles', 'Additional styling data for this page. How this is used depends on the template, but will usually be placed after all other stylesheets and style blocks.');
    if ($settings['script_fields'])
        $fields->render('scripts', 'Scripts', 'Additional script data for this page. How this is used depends on the template, but will usually be placed after all other stylesheets and style blocks.');
        
    $fields->form_end();
    