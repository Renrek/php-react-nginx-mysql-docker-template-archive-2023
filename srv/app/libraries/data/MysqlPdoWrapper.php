<?php declare(strict_types=1);

namespace App\Libraries\Data;

use App\Config\DatabaseConst;
use PDO;

class MysqlPdoWrapper {

    public PDO $pdo;

    public function __construct(array $options) {
        $defaultOptions = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,// PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($defaultOptions, $options);
        $dsn = "mysql:host=".DatabaseConst::HOST.";dbname=".DatabaseConst::NAME.";port=".DatabaseConst::PORT.";charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, DatabaseConst::USER, DatabaseConst::PASS, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
 
    public function run(string $sql, array|null $args = NULL) : mixed
    {
        if (!$args)
        {
            return $this->pdo->query($sql);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}