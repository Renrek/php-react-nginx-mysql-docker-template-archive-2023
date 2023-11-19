<?php declare(strict_types=1);

    namespace App\Libraries\Controllers;

    use App\Libraries\Controllers\ControllerTrait;
    use App\Libraries\Injection\ContainerTrait;
    use App\Helpers\CsrfTokenTrait;

    class BaseApiController
    {
        use CsrfTokenTrait;
        use ControllerTrait;
        use ContainerTrait;
 
        protected function response(int $code, mixed $data=[]): void {
            $payload = json_encode($data);
            http_response_code($code);
            if (! empty($data)){
                echo $payload;
            }
        }

        protected function validateRequestMethods(array $methods): void {

        }
    }
