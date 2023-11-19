<?php declare(strict_types=1);

namespace App\Tests\Routes;

use App\Libraries\Testing\BaseTest;
use App\Routes\PageRoute;

final class PageRouteTest extends BaseTest {

    private PageRoute $route;

    public function setUp() : void {
        $this->route = new PageRoute();
    }

    public function testDefaults(): void {
        $results = $this->route->generate('', 'GET');
        $this->assertSame($results, ['HomeController', 'index', []]);
    }

    public function testNotFound(): void {
        $serverRequestUri = '/not-found';
        $results = $this->route->generate($serverRequestUri, 'GET');
        $this->assertSame($results, ['NotFoundController', 'index', []]);
    }
}