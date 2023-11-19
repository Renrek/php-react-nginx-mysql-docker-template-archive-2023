<?php declare(strict_types=1);

namespace App\Routes;

use App\Libraries\Routing\RouteAbstract;

class CustomApiRoute extends RouteAbstract{

    public function getClassPath(): string {
        return '/srv/app/api/custom/';
    }

    public static function getUriPrefix(): string {
        return '/api/v1/custom';
    }

    public function getNamespace(): string {
        return 'App\\Api\\Custom\\';
    }

    public function getClassSuffix(): string {
        return 'Api';
    }

    public function getAllowedRequestMethods(): array {
        return [ 'GET', 'POST', 'PUT', 'DELETE' ];
    }

    public function generate(string $requestPath, string $requestMethod): array {

        $this->validateRequestMethod($requestMethod);
        
        $uri = $this->getUri($requestPath);

        if (empty($uri[0])) {
            $this->handleNotFound();
        }

        $class = $this->formatClassName($uri[0]);
        array_shift($uri);
        
        $method = $this->formatMethodName($uri[0]);
        array_shift($uri);
    
        $this->validateRequest($class, $method);
        $params = $uri;
        $class .= $this->getClassSuffix();
        
        return [$class, $method, $params];
    }

    protected function handleNotFound () : void {
        http_response_code(404);
        die();
    }

}