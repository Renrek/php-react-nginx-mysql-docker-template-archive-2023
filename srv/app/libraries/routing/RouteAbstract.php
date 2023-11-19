<?php declare(strict_types=1);

namespace App\Libraries\Routing;

use App\Libraries\Routing\RouteInterface;

abstract class RouteAbstract implements RouteInterface {

    abstract protected function handleNotFound () : void ;

    protected function formatClassName (string $rawName) : string {

        $classElements = explode('-', $rawName);

        foreach ($classElements as $key => $value) {
            $classElements[$key] = \ucfirst($value);
        }

        return implode($classElements);

    }

    protected function formatMethodName(string $rawName) : string {
    
        $classElements = explode('-', $rawName);

        foreach ($classElements as $key => $value) {
            $classElements[$key] = \ucfirst($value);
        }

        return lcfirst(implode($classElements));
      
    }

    protected function validateRequest( string $class, string $method ): void {

        $file = $this->getClassPath().$class.$this->getClassSuffix().'.php';
        if(!file_exists($file)){
            $this->handleNotFound();
        }

        $fullClassName = $this->getNamespace().$class.$this->getClassSuffix();
        if(!class_exists($fullClassName)){
            $this->handleNotFound();
        }
        
        if(!method_exists(new $fullClassName, $method)){
            $this->handleNotFound();
        }
        
    }

    protected function validateRequestMethod( string $requestMethod ) : void {
        if (!in_array($requestMethod, $this->getAllowedRequestMethods())){
            $this->handleNotFound();
        }
    }

    protected function getUri(string $requestPath): array {
        
        $prefix = $this->getUriPrefix();
        if (substr($requestPath, 0, strlen($prefix)) === $prefix){
            $requestPath = substr($requestPath, strlen($prefix));
        }

        $requestPath = rtrim(ltrim($requestPath, '/'));
        $requestPath = filter_var($requestPath, FILTER_SANITIZE_URL);
        
        return explode('/', $requestPath);
    }
}