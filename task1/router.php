<?php

function routeRequest(): void
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = rtrim($uri, '/') ?: '/';

    $routes = [
        '/task1'        => 'controllers/index.php',
        '/task1/modules' => 'modules.php',
        '/task1/module'  => 'module.php',
        '/task1/events'  => 'events.php',
    ];

    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
    }
}

routeRequest();
