<?php

namespace App\Core;

abstract class Middleware {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    abstract function handle($request, $response, $next);

    public function __invoke($request, $response, $next) {
        return $this->handle($request, $response, $next);
    }

}
