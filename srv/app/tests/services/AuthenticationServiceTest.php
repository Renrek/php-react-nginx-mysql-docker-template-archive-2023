<?php declare(strict_types=1);

namespace App\Tests\Services;

use App\Libraries\Testing\BaseTest;
use App\Services\AuthenticationService;

final class AuthenticationServiceTest extends BaseTest {

    public AuthenticationService $authService;

    public function setUp() : void {
       $this->authService = $this->resource()->get(AuthenticationService::class);
    }

    public function testCreatePassword(): void {
        $passwordHash = $this->authService->createPassword('goat');
        $this->assertTrue($passwordHash);
    }

    public function testVerifyPassword(): void {
        
    }
}