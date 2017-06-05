<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctAuth extends Middleware {

    public function handle($request, $response, $next) {
        if ($this->auth()->check()) {
            return($this->redirect($response, "index"));
        }
        $response = $next($request, $response);
        return $response;
    }

}
