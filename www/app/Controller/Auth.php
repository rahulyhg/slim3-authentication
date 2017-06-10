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
    public function getLogin() {
        return($this->render("auth/login.twig"));
    }

    /**
     * 
     */
    public function getLogout() {

        // 
        Session::destroy();

        // 
        $key = $this->config("cookies/user_remember");
        if (Cookie::exists($key)) {
            $user = $this->auth()->user();
            if ($user->removeRememberCredentials()) {
                Cookie::delete($key);
            }
        }
        return($this->redirect("auth.login"));
    }

    /**
     * 
     */
    public function getRegister() {
        return($this->render("auth/register.twig"));
    }

    /**
     * 
     */
    public function postLogin() {

        // 
        $validation = $this->validate([
            "email_or_username" => Validator::notEmpty(),
            "password" => Validator::notEmpty()
        ]);

        // 
        if (!$validation->passed()) {
            return($this->redirect("auth.login"));
        }

        //
        $emailOrUsername = $this->param("email_or_username");
        $user = User::where("email", $emailOrUsername)->orWhere("username", $emailOrUsername)->first();
        if (!$user or $user->password !== Hash::generate($this->param("password"), $user->salt)) {
            $this->flash("danger", $this->text("login/invalid"));
            return($this->redirect("auth.login"));
        }

        // 
        Session::put($this->config("sessions/user_id"), $user->id);

        // 
        if ($this->param("remember") === "on") {
            $rememberIdentifier = Hash::generateSalt(128);
            $rememberToken = Hash::generateSalt(128);
            if ($user->updateRememberCredentials($rememberIdentifier, Hash::generate($rememberToken))) {
                $key = $this->config("cookies/user_remember");
                $value = "{$rememberIdentifier}.{$rememberToken}";
                Cookie::put($key, $value, 604800);
            }
        }

        return($this->redirect("index"));
    }

    /**
     * 
     */
    public function postRegister() {

        // 
        $validation = $this->validate([
            "forename" => Validator::max(100)->notEmpty()->noWhitespace()->alpha(),
            "surname" => Validator::max(100)->notEmpty()->noWhitespace()->alpha(),
            "username" => Validator::max(32)->notEmpty()->noWhitespace()->alnum(),
            "email" => Validator::max(254)->notEmpty()->noWhitespace()->email()->emailUnique(),
            "password" => Validator::max(8)->notEmpty()->noWhitespace(),
            "password_repeat" => Validator::max(8)->notEmpty()->noWhitespace()->identical("password"),
        ]);

        // 
        if (!$validation->passed()) {
            return($this->redirect("auth.register"));
        }

        // 
        $user = User::create([
                    "salt" => ($salt = Hash::generateSalt(32)),
                    "email" => $this->param("email"),
                    "forename" => $this->param("forename"),
                    "password" => Hash::generate($this->param("password"), $salt),
                    "surname" => $this->param("surname"),
                    "username" => $this->param("username")
        ]);

        // 
        if (!$user) {
            $this->flash("danger", $this->text("register/error"));
            return($this->redirect("auth.register"));
        }

        // 
        $this->flash("success", $this->text("register/success"));
        return($this->redirect("auth.login"));
    }

}
