<?php

    $ROUTE_MAP = array(
    
        // Image sizing on demand
        '/image/:size/*',
    
        // Route any request starting with 'admin' to the admin section.
        '/admin/',
        '/admin/logout/',
        '/admin/menu/',
        '/admin/menu/:view/',
        '/admin/edit/',
        '/admin/edit/:view/:id',
        '/admin/:section/*',
        
        // Route any request startign with blog that contains an ID to the
        // blog section
        '/blog/:id/',
    
        // Subspections for dynamically generated pages. In this case, ':id'
        // would appear in the fs as a dir named '_id'.
        //'/examples/:id/',
        '/examples/:id/thingy/*',
    
    );