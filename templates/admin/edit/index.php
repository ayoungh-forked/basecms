<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BaseCMS Admin | Menu</title>
        <link href="/styles/admin/fonts.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/edit.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/vendor/jquery/jquery.min-1.8.3.js"></script>
        <script type="text/javascript" src="/scripts/admin/edit.js"></script>
        <script type="text/javascript" src="/scripts/vendor/xing/wysihtml5-0.4.0pre.min.js"></script>
        <script type="text/javascript" src="/scripts/vendor/xing/parser_rules/advanced.js"></script>
        <script type="text/javascript" src="/scripts/admin/edit.js"></script>
    </head>
    <body>
        <?php
            $section = $request->params['view'];
            
            switch($section) {
                case 'pages':
                    $t = 'pages.php';
                    break;
                default:
                    $t = null;
            }
            
            if ($t)
                $this->include_template("/admin/edit/includes/$t");
            else {
        ?>
    
        <div class="default_message">
            <h3>Welcome back to Base</h3>
            <p>
                Use the menu on the left to get started.
            </p>
        </div>
        
        <?php
            }
        ?>
        
    </body>
</html>