<?php

    use BaseCMS\core\Users as u;
    
    u::log_out();
    $request->redirect("/admin/");