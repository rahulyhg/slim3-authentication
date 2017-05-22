<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctGuests extends Middleware {

    public function handle($request, $response, $next) {
        if (!$this->container->auth->check()) {
            return $response->withRedirect($this->container->router->pathFor("login"));
        }
        return $next($request, $response);
    }

}
