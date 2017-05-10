<?php

namespace App\Controller;

use App\Core\Controller as BaseController;

class Register extends BaseController {

    public function index($request, $response) {
        return $this->ContainerInterface->view->render($response, "register/register.twig");
    }

    public function register($request, $response) {
        return $response->withRedirect($this->ContainerInterface->router->pathFor("register"));
    }

}
