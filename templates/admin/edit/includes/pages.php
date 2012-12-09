<?php

    use BaseCMS\core\Users as u;
    use BaseCMS\core\templating\Fields as Fields;
    
    use BaseCMS\db\RowObject as RowObject;
    
    $user = u::current_user();

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
        //'tags' => 'tags',
        'content' => 'html',
        //'styles' => 'css',
        //'scripts' => 'js',
        'developer_lock' => 'bool',
        'admin_lock' => 'bool',
        'live_from' => 'datetime',
        'live_until' => 'datetime',
        'redirect' => 'url'
    );

    $fields = new Fields($fieldmap, $record, false);
    $fields->form_start();  
?>
<h2>Edit page</h2>
<?php
    $fields->render('title');
    $fields->render('url_path', 'Path', 'How you want this page to appear in the URL. Eg., <em>sample-page</em>');
    $fields->render('template', 'Select a template');
    $fields->render('content', 'Page content');
    $fields->render('tags');
?>
<h3>Page settings</h3>
<?php
    $fields->render('live', 'Make this page live');
    if ($user['admin'])
        $fields->render('admin_lock', 'Administrator lock');
    if ($user['developer'])
        $fields->render('developer_lock', 'Developer lock');
    $fields->render('redirect', 'Redirect URL', 'Instead of displaying this page, redirect this URL to another page.');
    $fields->render('keywords', 'Page keywords', 'A <strong>few</strong> relevant terms or subjects related to this page\'s content.');
    $fields->render('description', 'Page description', 'The description for this page. This will not appear on the page itself, but will be used by web crawlers and search engines like Google when displaying a summary for this page.');
    $fields->form_end();
    