<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctAuthenticated extends Middleware {

    public function handle($request, $response, $next) {
        if ($this->container->auth->check()) {
            return $response->withRedirect($this->container->router->pathFor("index"));
        }
        return $next($request, $response);
    }

}
