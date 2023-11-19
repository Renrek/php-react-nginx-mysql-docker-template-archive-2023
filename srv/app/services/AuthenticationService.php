<?php declare(strict_types=1);

namespace App\Services;

use App\Libraries\Core\Service; 
use App\Models\UserModel;

final class AuthenticationService extends Service {

    private $userId;
    
    public function __construct(
        private UserModel $user
    ) {}
    
    public function getUserId(): int {
        return $this->userId;
    }

    public function createPassword(string $password) : bool
    {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        //DB store hash
        //return false; //on fail
        return true; //on success
    }

    public function verifyPassword(string $email, string $password) : bool
    {
        $user = $this->user->getFullUserByEmail($email);
        if (password_verify($password, $user->passwordHash)){
            $this->userId = $user->id;
            return true;
        }
        return false;
    }

    public function emailExists(string $email): bool
    {
        
    }
}