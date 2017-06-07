<?php

namespace App\Middleware;

use App\Core\Middleware;

class RestirctAuth extends Middleware {

    public function handle($request, $response, $next) {
        if (!$this->auth()->check()) {
            $response = $next($request, $response);
            return $response;
        }
        $this->flash("danger", $this->text(""));
        return($this->redirect($response, "index"));
    }

}
