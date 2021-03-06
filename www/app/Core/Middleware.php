<?php

namespace App\Core;

/**
 * 
 */
abstract class Middleware {

    /** @var type */
    protected $container;

    /**
     * 
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * 
     */
    protected function auth() {
        return($this->container->auth);
    }

    /**
     * 
     */
    protected function config($key, $default = null) {
        return($this->container->config->get($key, $default));
    }

    /**
     * 
     */
    protected function flash($type, $message) {
        return($this->container->flash->addMessage($type, $message));
    }

    /**
     * 
     */
    protected function hash(){
        return($this->container->hash);
    }
    
    /**
     * 
     */
    protected function test($name, $value) {
        return($this->container->view->getEnvironment()->addGlobal($name, $value));
    }

    /**
     * 
     */
    abstract function handle($request, $response, $next);

    /**
     * 
     */
    protected function redirect($response, $path, array $data = [], array $params = []) {
        return($response->withRedirect($this->container->router->pathFor($path, $data, $params)));
    }

    /**
     * 
     */
    protected function text($key) {
        return($this->config("texts.{$key}"));
    }

    /**
     * 
     */
    protected function user() {
        return($this->auth()->user());
    }

    /**
     * 
     */
    public function __invoke($request, $response, $next) {
        return($this->handle($request, $response, $next));
    }

}
