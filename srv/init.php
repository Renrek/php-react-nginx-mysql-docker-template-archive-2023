<?php declare(strict_types=1);

    require_once 'app/libraries/core/Bootstrap.php';
    $bootstrap = new App\Libraries\Core\Bootstrap();
    $bootstrap->init();
    $bootstrap->startSession();

    $requestParser = new App\Libraries\Routing\RequestParser();
    $requestPath = $requestParser->getPath();

    $routeManager = new App\Routes\RouteManager();
    $route = $routeManager->getRoute($requestPath);
    
    $router = new App\Libraries\Routing\Router($route, $requestParser);
    