<?php declare(strict_types=1);

namespace App\Libraries\Data;

use App\Libraries\Data\MysqlPdoWrapper;

class DB extends MysqlPdoWrapper {

    public function __construct() {
        parent::__construct([]);
    }
}