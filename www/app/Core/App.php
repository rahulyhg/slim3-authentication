<?php

namespace App\Core;

use Slim\App as Slim;

class App extends Slim {

    public function route(array $methods, $pattern, $class, $method = "") {
        if ($method) {
            return $this->map($methods, $pattern, function($request, $response, $args) use ($class, $method) {
                return(call_user_func_array([new $class($this, $request, $response), $request->getMethod() . ucfirst($method)], $args));
            });
        }
        return $this->map($methods, $pattern, function($request, $response, $args) use ($class) {
            return(call_user_func_array([new $class($this, $request, $response), $request->getMethod()], $args));
        });
    }

}
