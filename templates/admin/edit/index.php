<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BaseCMS Admin | Menu</title>
        <link href="/styles/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/fonts.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/edit.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/vendor/jquery/jquery.min-1.8.3.js"></script>
        <script type="text/javascript" src="/scripts/vendor/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/vendor/xing/wysihtml5-0.4.0pre.min.js"></script>
        <script type="text/javascript" src="/scripts/vendor/xing/parser_rules/advanced.js"></script>
        <script type="text/javascript" src="/scripts/admin/helpers.js"></script>
        <script type="text/javascript" src="/scripts/admin/edit.js"></script>
    </head>
    <body>
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
        
            <div class="default_message span12 hero-unit">
                <h3>Welcome back to Base</h3>
                <p>
                    Use the menu on the left to get started.
                </p>
            </div>
            
            <?php
                }
            ?>
        </div>
        
    </body>
</html>