<?php declare(strict_types=1);

namespace App\Models;

use App\Libraries\Core\Model;
use App\Libraries\Data\DB;

class UserModel extends Model
{ 
    public function __construct(DB $db)
    {
        $this->db = $db;
        $this->table = 'user';
        $this->primaryKey = 'id';
        $this->publicFields = ['id', 'email', 'firstName', 'lastName', 'createdAt', 'updatedAt'];
    }

    public function getAll() : array
    {   
        $statement = $this->selectPrefix();
        return $this->db->run($statement, [])->fetchAll();
    }

    public function getFullUserByEmail(string $email):object {
        $this->publicFields[] = 'passwordHash';
        $statement = $this->selectPrefix() . ' WHERE email = ?';
        return $this->db->run($statement, [$email])->fetch();
    }
}
