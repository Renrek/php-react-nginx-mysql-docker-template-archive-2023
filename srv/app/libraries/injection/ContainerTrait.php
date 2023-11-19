<?php declare(strict_types=1);

namespace App\Libraries\Injection;

trait ContainerTrait {

    protected function resource(): object{
        return new Container();
    }
    
}