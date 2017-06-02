<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctGuests extends Middleware {

    public function handle($request, $response, $next) {
        if (!$this->auth()->check()) {
            return($this->redirect("auth.login"));
        }
        return $next($request, $response);
    }

}
