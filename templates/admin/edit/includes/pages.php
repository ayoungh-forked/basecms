<?php

    use BaseCMS\core\templating\Fields as Fields;

    $id = $request->params['id'];
    $page = $db->get_one('pages', array('id' => $id));

    $row_array = $page->_get_row();
    
    $fieldmap = array(
        'title' => 'input',
        'url_path' => 'url:path_fragment',
        'live' => 'bool',
        'template' => 'template',
        'description' => 'text',
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

    $fields = new Fields($fieldmap, $row_array);
        
    $fields->render('live', 'Make this page live');
    $fields->render('title');
    $fields->render('url_path', 'Path', 'How you want this page to appear in the URL. Eg., <em>sample-page</em>');
    $fields->render('redirect', 'Redirect URL', 'Instead of displaying this page, redirect this URL to another page.');
    $fields->render('template', 'Select a template');
    
    $fields->render('tags');
    
    $fields->render('keywords', 'Page keywords', 'A <strong>few</strong> relevant terms or subjects related to this page\'s content.');
    $fields->render('description', 'Page description', 'The description for this page. This will not appear on the page itself, but will be used by web crawlers and search engines like Google when displaying a summary for this page.');
    
    $fields->output();