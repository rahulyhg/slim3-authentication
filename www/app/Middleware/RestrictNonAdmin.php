<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestrictNonAdmin extends Middleware {

    public function handle($request, $response, $next) {
        if ($this->auth()->check()) {
            if ($this->user()->isAdmin() or $this->user()->isSuperAdmin()) {
                $response = $next($request, $response);
                return $response;
            }
        }
    }

}
