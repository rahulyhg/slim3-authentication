<?php

namespace App\Controller\Auth;

use App\Core\Controller;
use App\Model\User;
use App\Utility\Cookie;
use App\Utility\Session;
use Respect\Validation\Validator as v;

class Login extends Controller {

    public function get() {
        return($this->render("auth/login.twig"));
    }

    public function post() {
        $validation = $this->validate([
            "email_or_username" => v::notEmpty(),
            "password" => v::notEmpty()
        ]);
        if ($validation->passed()) {
            $emailOrUsername = $this->param("email_or_username");
            $user = User::where("email", $emailOrUsername)->orWhere("username", $emailOrUsername)->first();
            if (!$user or !$this->hash()->passwordVerify($user->password, $this->param("password"), $user->salt)) {
                $this->flash("danger", $this->text("login.invalid"));
            } elseif ($user and ! $user->activated) {
                $this->flash("warning", $this->text("login.not_activated"));
            } elseif($user) {
                Session::put($this->config("sessions.user_id"), $user->id);
                $this->remember($user, ($this->param("remember") === "on"));
                return($this->redirect("index"));
            }
        }
        return($this->redirect("auth.login"));
    }

    private function remember($user, $remember) {
        if ($remember) {
            $identifier = $this->hash()->salt(128);
            $token = $this->hash()->salt(128);
            $user->updateRememberCredentials($identifier, $this->hash()->generate($token));
            Cookie::put($this->config("cookies.user_remember"), "{$identifier}.{$token}", 604800);
        }
    }
    
    public function getTest(){
        return(json_encode(["test" => "test"]));
    }

}
