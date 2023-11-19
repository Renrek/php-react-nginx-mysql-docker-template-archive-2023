<?php declare(strict_types=1);

namespace App\Libraries\Core;

use App\Config\AppConst;
use ErrorException;
use Exception;

class Bootstrap {

    public function __construct(){}

    public function init(): void {
        //error_reporting(E_ALL);
        //$this->errorHandler();
        //$this->exceptionHandler(); // Enable this in production
        $this->classAutoLoaders();
        $this->loadGlobals();
    }

    public function startSession(): void {
        session_start();
        $this->checkClientAddress();
    }

    private function classAutoLoaders(): void {

        // Composer Dependencies
        require_once '/srv/app/libraries/vendors/autoload.php';

        // Application Classes
        spl_autoload_register(function($className){
            $baseDirectory = '/srv/app';
            $prefix = 'App\\';
            $prefixLength = strlen($prefix);
            if (strncmp($prefix, $className, $prefixLength) !== 0) {
                return;
            }
            $suffix = substr($className, $prefixLength);
            $suffix = strtolower($suffix);
            $fullFilePath = $baseDirectory . '/' 
                . str_replace('\\', '/', $suffix) . '.php';
            if (file_exists($fullFilePath)) {
                require_once $fullFilePath;
            }
        });
    }

    // For the places that I don't want to instantiate a class to get a variable
    private function loadGlobals(): void {
        define('APP_ROOT', AppConst::APP_ROOT);
        define('URL_ROOT', AppConst::URL_ROOT);
        define('SITE_NAME', AppConst::SITE_NAME);
    }

    private function exceptionHandler(): void {
        set_exception_handler(function(\Throwable $exception){
            //$code = $exception->getCode();
            //$code = ($code !== 404)? 500: 404;
            //http_response_code($code);
            
            //var_dump($exception);
        });
    }

    private function errorHandler(): void {
        set_error_handler(function(
            int $errno,
            string $errstr,
            string $errfile,
            int $errline
        ){
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }


    private function checkClientAddress(){

        if(!isset($_SERVER['REMOTE_ADDR'])) {
            throw new \Exception('Something went wrong with fetching client IP');
        }

        if(isset($_SESSION['ipAddress'])){
            if ($_SERVER['REMOTE_ADDR'] !== $_SESSION['ipAddress']){
                session_unset();
                session_destroy();
            }
        } else {
            $_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
            
        }
    }
}