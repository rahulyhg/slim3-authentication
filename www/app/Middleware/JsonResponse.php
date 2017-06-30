<?php

namespace App\Middleware;

use App\Core;

class JsonResponse extends Core\Middleware {

    public function handle($request, $response, $next) {
        $response = $next($request, $response->withHeader("Content-type", "application/json"));
        return $response;
    }

}
