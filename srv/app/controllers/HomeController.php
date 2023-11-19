<?php declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\Controllers\BaseViewController;

use App\Services\AuthenticationService;

class HomeController extends BaseViewController {

    public function index(): void 
    {   
        $data = (object) [];

        $data->header = "Header Text";

        $data->csrfTokenFormElement = $this->generateCsrfFormElement();

        if(isset($_SESSION)){
            $loggedIn = \array_key_exists('userId', $_SESSION);
        } else {
            $loggedIn = false;
        }
        
        $data->loginElement = $this->generateReactElement(
            'authentication', 
            [ 
                'loggedIn' => $loggedIn,
            ]
        );

        $this->render('home/index', $data, 'Welcome');
    }
}