<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\User;
use App\Utility\Hash;
use Respect\Validation\Validator;

/**
 * 
 */
class Auth extends Controller {

    /**
     * 
     */
    public function getLogin($request, $response) {
        return($this->container->view->render($response, "auth/login.twig"));
    }

    /**
     * 
     */
    public function getLogout($request, $response) {
        $this->container->auth->logout();
        return($response->withRedirect($this->router->pathFor("auth.login")));
    }

    /**
     * 
     */
    public function getRegister($request, $response) {
        return($this->container->view->render($response, "auth/register.twig"));
    }

    /**
     * 
     */
    public function postLogin($request, $response) {

        $validation = $this->validator->validate($request, [
            "email" => Validator::notEmpty()->email(),
            "password" => Validator::notEmpty()
        ]);

        if (!$validation->passed()) {
            return($response->withRedirect($this->router->pathFor("auth.login")));
        }

        $email = $request->getParam("email");
        $password = $request->getParam("password");
        $remember = false;
        if (!$this->container->auth->login($email, $password, $remember)) {
            return($response->withRedirect($this->router->pathFor("auth.login")));
        }
        return($response->withRedirect($this->router->pathFor("index")));
    }

    /**
     * 
     */
    public function postRegister($request, $response) {

        $validation = $this->validator->validate($request, [
            "forename" => Validator::notEmpty()->noWhitespace()->alpha(),
            "surname" => Validator::notEmpty()->noWhitespace()->alpha(),
            "username" => Validator::notEmpty()->noWhitespace()->alpha(),
            "email" => Validator::notEmpty()->noWhitespace()->email()->emailUnique(),
            "password" => Validator::notEmpty()->noWhitespace()->identical("password_repeat"),
            "password_repeat" => Validator::notEmpty()->noWhitespace()->identical("password"),
        ]);

        if (!$validation->passed()) {
            return($response->withRedirect($this->router->pathFor("auth.register")));
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
            return($response->withRedirect($this->router->pathFor("auth.register")));
        }

        return($response->withRedirect($this->router->pathFor("auth.login")));
    }

}
