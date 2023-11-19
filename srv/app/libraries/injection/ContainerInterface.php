<?php declare(strict_types=1);

namespace App\Libraries\Injection;

interface ContainerInterface {

    public function get(string $id): mixed;

    public function has(string $id): bool;

}