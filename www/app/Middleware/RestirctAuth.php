<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctAuth extends Middleware {

    public function handle($request, $response, $next) {
        if ($this->auth()->check()) {
            return($this->redirect("index"));
        }
        return $next($request, $response);
    }

}
