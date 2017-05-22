<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\User;
use App\Utility\Hash;
use Respect\Validation\Validator;

class Register extends Controller {

    public function index($request, $response) {
        return $this->container->view->render($response, "register/register.twig");
    }

    public function register($request, $response) {

        $validation = $this->validator->validate($request, [
            "forename" => Validator::notEmpty()->noWhitespace()->alpha(),
            "surname" => Validator::notEmpty()->noWhitespace()->alpha(),
            "username" => Validator::notEmpty()->noWhitespace()->alpha(),
            "email" => Validator::notEmpty()->noWhitespace()->email()->emailUnique(),
            "password" => Validator::notEmpty()->noWhitespace()->identical("password_repeat"),
            "password_repeat" => Validator::notEmpty()->noWhitespace()->identical("password"),
        ]);

        if (!$validation->passed()) {
            return $response->withRedirect($this->router->pathFor("register"));
        }

        $user = User::create([
            "salt" => ($salt = Hash::generateSalt(32)),
            "email" => $request->getParam("email"),
            "forename" => $request->getParam("forename"),
            "password" => Hash::generate($request->getParam("password"), $salt),
            "surname" => $request->getParam("surname"),
            "username" => $request->getParam("username")
        ]);
        if (!$user) {
            return($response->withRedirect($this->router->pathFor("register")));
        }
        
        return($response->withRedirect($this->router->pathFor("login")));
    }

}
