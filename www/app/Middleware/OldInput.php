<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Utility\Session;

class OldInput extends Middleware {

    public function handle($request, $response, $next) {
        $this->test("input", Session::get("input"));
        Session::put("input", $request->getParams());
        $response = $next($request, $response);
        return $response;
    }

}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            