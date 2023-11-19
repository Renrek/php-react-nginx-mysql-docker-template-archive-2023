<?php declare(strict_types=1);

namespace App\Routes;

use App\Libraries\Routing\RouteAbstract;

class RestApiRoute extends RouteAbstract{

    public function getClassPath(): string {
        return '/srv/app/api/standard/';
    }

    public static function getUriPrefix(): string {
        return '/api/v1/rest';
    }

    public function getNamespace(): string {
        return 'App\\Api\\Standard\\';
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

        if ($requestMethod === 'GET' && !empty($uri[0])){
            $method = 'get';
        } else { 
            // If no id is provided run basic requests 
            $method = match ($requestMethod){
                'GET' => 'list',
                'POST' => 'create',
                'PUT' => 'update',
                'DELETE' => 'delete',
            };
        }

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