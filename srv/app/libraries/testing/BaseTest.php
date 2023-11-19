<?php declare(strict_types=1);

namespace App\Libraries\Testing;

use PHPUnit\Framework\TestCase;
use App\Libraries\Injection\ContainerTrait;

class BaseTest extends TestCase {
    use ContainerTrait;
}