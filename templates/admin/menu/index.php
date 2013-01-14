<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BaseCMS Admin | Menu</title>
        <link rel="author" href="humans.txt" />
        <link href="/styles/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/fonts.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/menu.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/vendor/jquery/jquery.min-1.8.3.js"></script>
        <script type="text/javascript" src="/scripts/vendor/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/admin/helpers.js"></script>
        <script type="text/javascript" src="/scripts/vendor/jquery/plugins/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="/scripts/vendor/jquery/plugins/jquery.mjs.nestedSortable-2.0.js"></script>
        <script type="text/javascript" src="/scripts/admin/menu.js"></script>
    </head>
    <body id="menu">
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
                
                $this->include_template("/admin/menu/includes/$t");
            
            ?>
        </div>
    </body>
</html>









