<?php

namespace App\Core;

/**
 * 
 */
abstract class Controller {

    /** @var type */
    protected $container;

    /** @var object */
    protected $response;

    /** @var object */
    protected $request;

    /**
     * 
     */
    public function __construct($container, $request, $response) {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
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
    protected function param($key, $default = null) {
        return($this->request->getParam($key, $default));
    }

    /**
     * 
     */
    protected function redirect($path, array $data = [], array $params = []) {
        return($this->response->withRedirect($this->container->router->pathFor($path, $data, $params)));
    }

    /**
     * 
     */
    protected function render($path, array $args = []) {
        return($this->container->view->render($this->response, $path, $args));
    }

    /**
     * 
     */
    protected function text($key) {
        return($this->config("texts/{$key}"));
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
    protected function validate(array $rules) {
        return($this->container->validator->validate($this->request, $rules));
    }

}
