<?php

namespace App\Controller;

use App\Core\Controller as BaseController;

class Login extends BaseController {

    public function index($request, $response) {
        return $this->ContainerInterface->view->render($response, "login/login.twig");
    }

    public function login($request, $response) {
        return $response->withRedirect($this->ContainerInterface->router->pathFor("login"));
    }

}
