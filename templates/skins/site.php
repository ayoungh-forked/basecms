<!doctype html>
<html>
    <head>
        <title>Welcome to BaseCMS</title>
    </head>
    <body>
    
        <?=$this->include_next(); ?>
        
        <?php
            include(ROOT_DIR . 'config/metadata.php'); 
        ?>
        <footer>
            <hr>
            <p>BaseCMS v<?=$version?></p>
        </footer>
    </body>
</html>