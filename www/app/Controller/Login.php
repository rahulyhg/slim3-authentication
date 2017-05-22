<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\User;
use Respect\Validation\Validator;

class Login extends Controller {

    public function index($request, $response) {
        return $this->container->view->render($response, "login/login.twig");
    }

    public function login($request, $response) {
        
        $validation = $this->validator->validate($request, [
            "email" => Validator::notEmpty()->email(),
            "password" => Validator::notEmpty()
        ]);

        if (!$validation->passed()) {
            return $response->withRedirect($this->router->pathFor("login"));
        }
        
        
        $email = $request->getParam("email");
        $password = $request->getParam("password");
        $remember = false;
        if (!$this->container->auth->login($email, $password, $remember)) {
            return $response->withRedirect($this->router->pathFor("login"));
        }
        return $response->withRedirect($this->router->pathFor("index"));
    }

    public function logout($request, $response) {
        $this->container->auth->logout();
        return $response->withRedirect($this->router->pathFor("login"));
    }

}
