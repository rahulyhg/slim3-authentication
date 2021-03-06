<?php

namespace App\Controller\Auth;

use App\Core\Controller;
use Respect\Validation\Validator as v;

class Settings extends Controller {

    public function getAccount() {
        return($this->render("auth/settings/account.twig"));
    }

    public function getPassword() {
        return($this->render("auth/settings/password.twig"));
    }

    public function getProfile() {
        return($this->render("auth/settings/profile.twig"));
    }

    public function postAccount() {
        $validation = $this->validate([
            "username" => v::max(32)->notEmpty()->noWhitespace()->alnum()->usernameUnique($this->user()->username),
            "email" => v::max(254)->notEmpty()->noWhitespace()->email()->emailUnique($this->user()->email)
        ]);
        if ($validation->passed()) {
            $this->user()->update([
                "username" => $this->param("username"),
                "email" => $this->param("email")
            ]);
            $this->flash("success", $this->text("user.account_updated"));
        }
        return($this->redirect("auth.account"));
    }

    public function postPassword() {
        $validation = $this->validate([
            "current_password" => v::notEmpty()->noWhitespace(),
            "new_password" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("new_password_repeat")),
            "new_password_repeat" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("new_password"))
        ]);
        if ($validation->passed()) {
            if (!$this->hash()->passwordVerify($this->user()->password, $this->param("current_password"), $this->user()->salt)) {
                $this->flash("danger", $this->text("user.password_invalid"));
            } else {
                $this->user()->update([
                    "salt" => ($salt = $this->hash()->salt(32)),
                    "password" => $this->hash()->generate($this->param("new_password") . $salt)
                ]);
                $this->flash("success", $this->text("user.password_updated"));
            }
        }
        return($this->redirect("auth.password"));
    }

    public function postProfile() {
        $validation = $this->validate([
            "forename" => v::max(100)->notEmpty()->noWhitespace()->alpha(),
            "surname" => v::max(100)->notEmpty()->noWhitespace()->alpha(),
            "biography" => v::max(160),
            "location" => v::max(32),
            "website" => v::max(100)->url()
        ]);
        if ($validation->passed()) {
            $this->user()->update([
                "biography" => $this->param("biography"),
                "forename" => $this->param("forename"),
                "location" => $this->param("location"),
                "surname" => $this->param("surname"),
                "website" => $this->param("website")
            ]);
            $this->flash("success", $this->text("user.profile_updated"));
        }
        return($this->redirect("auth.profile"));
    }

}
