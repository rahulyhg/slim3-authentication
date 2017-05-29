<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\User;
use App\Model\UserCookie;
use App\Utility\Cookie;
use App\Utility\Hash;
use App\Utility\Session;
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
        if (Cookie::exists("user")) {
            $cookie = UserCookie::where("hash", Cookie::get("user"))->first();
            if ($cookie->delete()) {
                Cookie::delete($cookieName);
            }
        }
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
            "email_or_username" => Validator::notEmpty(),
            "password" => Validator::notEmpty()
        ]);

        if (!$validation->passed()) {
            return($response->withRedirect($this->router->pathFor("auth.login")));
        }

        $email = $request->getParam("email_or_username");
        $password = $request->getParam("password");

        if (!$this->container->auth->login($email, $password)) {
            $this->flash->addMessage("danger", "The login credentials combination you have entered is incorrect");
            return($response->withRedirect($this->router->pathFor("auth.login")));
        }

        if ($request->getParam("remember") === "on") {
            $userId = Session::get("user");
            $hash = UserCookie::where("user_id", "user")->first()->hash;
            if (!$hash) {
                $hash = Hash::generateUnique();
                UserCookie::create([
                    "hash" => $hash,
                    "user_id" => $userId
                ]);
            }
            Cookie::put("user", $hash, 604800);
        }
        return($response->withRedirect($this->router->pathFor("index")));
    }

    /**
     * 
     */
    public function postRegister($request, $response) {

        $validation = $this->validator->validate($request, [
            "forename" => Validator::max(100)->notEmpty()->noWhitespace()->alpha(),
            "surname" => Validator::max(100)->notEmpty()->noWhitespace()->alpha(),
            "username" => Validator::max(32)->notEmpty()->noWhitespace()->alnum(),
            "email" => Validator::max(254)->notEmpty()->noWhitespace()->email()->emailUnique(),
            "password" => Validator::max(8)->notEmpty()->noWhitespace(),
            "password_repeat" => Validator::max(8)->notEmpty()->noWhitespace()->identical("password"),
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
            $this->flash->addMessage("danger", "There was a problem creating your account!");
            return($response->withRedirect($this->router->pathFor("auth.register")));
        }

        $this->flash->addMessage("success", "Your account has been successfully created!");
        return($response->withRedirect($this->router->pathFor("auth.login")));
    }

}
