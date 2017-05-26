<?php

namespace App\Core;

use Interop\Container\ContainerInterface;

/**
 * 
 */
abstract class Middleware {

    /** @var type */
    protected $container;

    /**
     * 
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * 
     */
    abstract function handle($request, $response, $next);

    /**
     * 
     */
    public function __invoke($request, $response, $next) {
        return($this->handle($request, $response, $next));
    }

}
