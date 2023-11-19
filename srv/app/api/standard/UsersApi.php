<?php declare(strict_types=1);

namespace App\Api\Standard;

use App\Libraries\Controllers\BaseApiController;
use App\Services\UserRelationshipService;
use App\Libraries\Container\Container;

class UsersApi extends BaseApiController {

  public function __construct(){
   
  }

  public function list(): void {
    $userRelationshipService = $this->resource()->get(UserRelationshipService::class);
    $users = $userRelationshipService->getUsers();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $this->response(200, $users);
  }

  public function get(): void {
    $data = (object) [
      'test' => 'get',
      'number' => 23,
    ];
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  $this->response(200, $data);
  }

  public function create(): void {
    $data = (object) [
      'test' => 'create',
      'number' => 2399,
    ];
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $this->response(201, $data);
  }

  public function update(): void {
    $data = (object) [
      'test' => 'update',
      'number' => 23,
    ];
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
   $this->response(200, $data);
  }

  public function delete(): void {
    $data = (object) [
      'test' => 'delete',
      'number' => 23,
    ];
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $this->response(200, $data);
  }
}