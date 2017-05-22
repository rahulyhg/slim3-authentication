<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Utility\Session;

class OldInput extends Middleware {

    public function handle($request, $response, $next) {
        $this->container->view->getEnvironment()->addGlobal("input", Session::get("input"));
        Session::put("input", $request->getParams());
        return $next($request, $response);
    }

}
