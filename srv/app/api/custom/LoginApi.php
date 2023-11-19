<?php declare(strict_types=1);

namespace App\Api\Custom;

use App\Libraries\Controllers\BaseApiController;
use App\Services\AuthenticationService;
use App\Config\ResponseConst;

class LoginApi extends BaseApiController {

  public function verify(): void {

    $body = json_decode(file_get_contents('php://input'));
    $authService = $this->resource()->get(AuthenticationService::class);
    $isValid = $authService->verifyPassword($body->email, $body->password);
    
    if ($isValid) {
      $_SESSION['userId'] = $authService->getUserId();
    } 

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization");
    $this->response(ResponseConst::OK);
  }

  public function logOut(): void {
    session_unset();
    session_destroy();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $this->response(ResponseConst::OK, ['this' => 'ddd cool']);
  }

}