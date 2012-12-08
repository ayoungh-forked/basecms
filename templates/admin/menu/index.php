<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BaseCMS Admin | Menu</title>
        <link href="/styles/admin/fonts.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/menu.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/vendor/jquery/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="/scripts/vendor/jquery/plugins/jquery-ui-1.9.2.custom.js"></script>
        <script type="text/javascript" src="/scripts/vendor/jquery/plugins/jquery.mjs.nestedSortable-2.0.js"></script>
        <script type="text/javascript" src="/scripts/admin/menu.js"></script>
    </head>
    <body id="menu">
        <?php
            
            $view = $request->params['view'];
            switch ($view) {
                case 'pages':
                default:
                    $t = 'pages.php';
                    break;
            }
            
            $this->include_template("/admin/menu/includes/$t");
        
        ?>
    </body>
</html>









