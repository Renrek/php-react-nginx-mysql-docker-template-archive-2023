<?php declare(strict_types=1);

namespace App\Routes;

use App\Libraries\Routing\RouteAbstract;
use App\Routes\PageRoute;
use App\Routes\RestApiRoute;
use App\Routes\CustomApiRoute;

class RouteManager {

    public function getRoute(string $requestUri): RouteAbstract {
        return match (true) {

            str_starts_with(
                $requestUri, 
                RestApiRoute::getUriPrefix()
            ) => new RestApiRoute(),

            str_starts_with(
                $requestUri, 
                CustomApiRoute::getUriPrefix()
            ) => new CustomApiRoute(),
            
            default => new PageRoute(),
        };
    }
}