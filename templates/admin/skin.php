<?php
    $path = array_filter(explode('/', $request->path));
    $class = 'section-' . (implode(' subsection-', $path));
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>BaseCMS Admin</title>
        <link rel="author" href="humans.txt" />
        <link href="/styles/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/fonts.css" rel="stylesheet" type="text/css" />
        <link href="/styles/admin/main.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/scripts/vendor/jquery/jquery.min-1.8.3.js"></script>
        <script type="text/javascript" src="/scripts/vendor/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/admin/helpers.js"></script>
        <script type="text/javascript" src="/scripts/admin/main.js"></script>
    </head>
    <body id="<?=end($path) ?>" class="<?=$class ?>">
    
        <div class="container">
            <?php
                $this->include_next();
            ?>
        </div>
        
    </body>
</html>