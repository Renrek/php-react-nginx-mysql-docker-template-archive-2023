<?php declare(strict_types=1);

namespace App\Routes;

use App\Libraries\Routing\RouteAbstract;
use App\Controllers\NotFoundController;

class PageRoute extends RouteAbstract{

    private const DEFAULT_CONTROLLER = 'home';
    private const DEFAULT_METHOD = 'index';

    public function getClassPath(): string {
        return '/srv/app/controllers/';
    }

    public static function getUriPrefix(): string {
        return '';
    }

    public function getNamespace(): string {
        return 'App\\Controllers\\';
    }

    public function getClassSuffix(): string {
        return 'Controller';
    }

    public function getAllowedRequestMethods(): array {
        return [ 'GET', 'POST'];
    }

    public function generate(string $requestPath, string $requestMethod): array {

        $this->validateRequestMethod($requestMethod);
        
        $uri = $this->getUri($requestPath);

        $rawClass = !empty($uri[0]) ? $uri[0] : self::DEFAULT_CONTROLLER;
        $class = $this->formatClassName($rawClass);
        array_shift($uri);

        $rawMethod = !empty($uri[0]) ? $uri[0] : self::DEFAULT_METHOD;
        $method = $this->formatMethodName($rawMethod);
        array_shift($uri);

        $this->validateRequest($class, $method);
        $params = $uri;
        $class .= $this->getClassSuffix();

        return [$class, $method, $params];
    }

    protected function handleNotFound () : void {
        $notFound = new NotFoundController();
        $notFound->index();
        die();
    }
}