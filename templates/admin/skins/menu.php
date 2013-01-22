<?php
    $view = $request->params['view'];
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BaseCMS | Menu</title>
        <link rel="author" href="humans.txt" />
        <link href="/styles/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/styles/vendor/fort-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/fonts.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/menu.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/vendor/jquery/jquery.min-1.8.3.js"></script>
        <script type="text/javascript" src="/scripts/vendor/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/admin/helpers.js"></script>
        <script type="text/javascript" src="/scripts/vendor/jquery/plugins/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="/scripts/vendor/jquery/plugins/jquery.mjs.nestedSortable-2.0.js"></script>
        <script type="text/javascript" src="/scripts/admin/menu.js"></script>
    </head>
    <body id="menu" data-section="<?=$view?>">
        <?php
            $this->include_next();
        ?>
    </body>
</html>