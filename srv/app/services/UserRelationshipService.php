<?php declare(strict_types=1);

namespace App\Services;

use App\Libraries\Core\Service;
use App\Libraries\Data\DB;
use App\Models\UserModel;



class UserRelationshipService extends Service {

    
    public function __construct(
       private DB $db
    ){
       
    }

    public function getUsers(): array {
        
        $users = new UserModel($this->db);
        return $users->getAll();
    }
}