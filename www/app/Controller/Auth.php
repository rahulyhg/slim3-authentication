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
        $cookieName = $this->config("cookies/user_remember");
        if (Cookie::exists($cookieName)) {
            $cookie = UserCookie::where("hash", Cookie::get($cookieName))->first();
            if ($cookie->delete()) {
                Cookie::delete($cookieName);
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
            $hash = UserCookie::where("user_id", $user->id)->first()->hash;
            if (!$hash) {
                $hash = Hash::generateUnique();
                UserCookie::create(["hash" => $hash, "user_id" => $user->id]);
            }
            Cookie::put("user", $hash, 604800);
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
