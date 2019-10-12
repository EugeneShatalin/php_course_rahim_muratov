<?php
   $routes = [
        "/" => "../mvc/views/homepage.php",
        "/login" => "../mvc/views/login.php",
        "/register" => "../mvc/views/register.php",
        "/profile" => "../mvc/views/profile.php",
        "/admin" => "../mvc/views/admin.php"
    ];
    $route = $_SERVER['REQUEST_URI'];

    if(array_key_exists($route, $routes)) {
        include $routes[$route];
        exit;
    } else {
       var_dump(404);
    }

    
