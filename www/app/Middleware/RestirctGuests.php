<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctGuests extends Middleware {

    public function handle($request, $response, $next) {
        if ($this->auth()->check()) {
            $response = $next($request, $response);
            return $response;
        }
        $this->flash("danger", $this->text("requires_auth"));
        return($this->redirect($response, "auth.login"));
    }

}
