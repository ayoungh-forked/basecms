<?php
    $path = array_filter(explode('/', $request->path));
    $class = 'section-' . (implode(' subsection-', $path));
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <title>BaseCMS</title>
        <link rel="author" href="humans.txt" />
        <link href="/styles/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/styles/vendor/fort-awesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/fonts.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/main.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/vendor/jquery/jquery.min-1.8.3.js"></script>
        <script type="text/javascript" src="/scripts/vendor/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/admin/helpers.js"></script>
        <script type="text/javascript" src="/scripts/admin/main.js"></script>
    </head>
    <body id="<?=end($path) ?>" class="<?=$class ?>">
        <?php
            $this->include_next();
        ?>
    </body>
</html>