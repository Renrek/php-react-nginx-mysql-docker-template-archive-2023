<?php declare(strict_types=1);

namespace App\Libraries\Controllers;

use App\Controllers\NotFoundController;

trait ControllerTrait {

    protected function generateReactElement(
        string $componentName, 
        array $data = []
    ) : string {

        $parameters = base64_encode(json_encode($data));

        return '<div class="react-component" data-component="'
            .$componentName
            .'" data-parameters="'
            .$parameters.'"></div>';
    }   
    
    protected function sendToHome() : void 
    {
        header('location: '. URL_ROOT);
    }

    protected function sendToNotFound() : void
    {
        $notFound = new NotFoundController();
        $notFound->index();
    }
}