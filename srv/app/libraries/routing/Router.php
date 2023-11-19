<?php declare(strict_types=1);

namespace App\Libraries\Routing;

use App\Libraries\Routing\RouteInterface;
use App\Libraries\Routing\RequestParser;

final class Router {

    private string $class;
    private string $method;
    private array $params = [];

    public function __construct(
        private RouteInterface $route, 
        private RequestParser $requestParser
    ){

        $requestPath = $this->requestParser->getPath();
        $requestMethod = $this->requestParser->getMethod();

        [$this->class, $this->method, $this->params] = 
            $this->route->generate($requestPath, $requestMethod);
        
        $this->class = $this->route->getNamespace() . $this->class;

        $this->callRoute();

    }

    private function callRoute(): void
    {
        call_user_func_array([new $this->class, $this->method], $this->params);
    }
}