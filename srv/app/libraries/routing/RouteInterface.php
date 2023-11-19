<?php declare(strict_types=1);

namespace App\Libraries\Routing;

interface RouteInterface {

    public function getClassPath(): string;

    public static function getUriPrefix(): string;

    public function getNamespace(): string;

    public function getAllowedRequestMethods(): array;

    public function getClassSuffix(): string;

    public function generate(string $requestPath, string $requestMethod): array;

}