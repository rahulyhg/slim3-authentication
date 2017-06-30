<?php

namespace App\Controller\Auth;

use App\Core\Controller;
use App\Model\User;
use Respect\Validation\Validator as v;

class Register extends Controller {

    public function get() {
        return($this->render("auth/register.twig"));
    }

    public function post() {
        $validation = $this->validate([
            "forename" => v::max(100)->notEmpty()->noWhitespace()->alpha(),
            "surname" => v::max(100)->notEmpty()->noWhitespace()->alpha(),
            "username" => v::max(32)->notEmpty()->noWhitespace()->alnum()->usernameUnique(),
            "email" => v::max(254)->notEmpty()->noWhitespace()->email()->emailUnique(),
            "password" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("password_repeat")),
            "password_repeat" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("password")),
        ]);
        if ($validation->passed()) {
            $user = User::create([
                "activation_code" => ($activationCode = $this->hash()->unique()),
                "salt" => ($salt = $this->hash()->salt(32)),
                "email" => $this->param("email"),
                "forename" => $this->param("forename"),
                "password" => $this->hash()->generate($this->param("password") . $salt),
                "surname" => $this->param("surname"),
                "username" => $this->param("username")
            ]);
            if ($this->config("app.activation")) {
                // send email
                $this->flash("info", $this->text("register.requires_mail_activation"));
            } else {
                $user->update([
                    "activated" => true,
                    "activation_code" => ""
                ]);
                $this->flash("success", $this->text("register.success"));
            }
            return($this->redirect("auth.login"));
        }
        return($this->redirect("auth.register"));
    }

}
