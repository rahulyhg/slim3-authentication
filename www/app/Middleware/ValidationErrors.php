<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Utility\Session;

class ValidationErrors extends Middleware {

    public function handle($request, $response, $next) {
        $this->container->view->getEnvironment()->addGlobal("errors", Session::get("errors"));
        Session::delete("errors");
        return $next($request, $response);
    }

}
