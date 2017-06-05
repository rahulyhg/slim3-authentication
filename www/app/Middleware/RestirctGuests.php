<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctGuests extends Middleware {

    public function handle($request, $response, $next) {
        if (!$this->auth()->check()) {
            $this->flash("danger", $this->text(""));
            return($this->redirect($response, "auth.login"));
        }
        $response = $next($request, $response);
        return $response;
    }

}
