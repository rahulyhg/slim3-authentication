<?php

namespace App\Controller;

use App\Core;
use App\Utility;
use Respect\Validation\Validator as v;

/**
 * User Controller:
 */
class User extends Core\Controller {

    /**
     * Get Account:
     */
    public function getAccount() {
        return($this->render("user/account.twig"));
    }

    /**
     * Get Password:
     */
    public function getPassword() {
        return($this->render("user/password.twig"));
    }

    /**
     * Get Profile:
     */
    public function getProfile() {
        return($this->render("user/profile.twig"));
    }

    /**
     * Post Account:
     */
    public function postAccount() {
        $validation = $this->validate([
            "username" => v::max(32)->notEmpty()->noWhitespace()->alnum()->usernameUnique($this->user()->username),
            "email" => v::max(254)->notEmpty()->noWhitespace()->email()->emailUnique($this->user()->email)
        ]);
        if ($validation->passed()) {
            $user = $this->user()->update([
                "username" => $this->param("username"),
                "email" => $this->param("email")
            ]);
            if ($user) {
                $this->flash("success", $this->text("user/account_updated"));
            }
        }
        return($this->redirect("user.account"));
    }

    /**
     * Post Password:
     */
    public function postPassword() {
        $validation = $this->validate([
            "current_password" => v::notEmpty()->noWhitespace(),
            "new_password" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("new_password_repeat")),
            "new_password_repeat" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("new_password"))
        ]);
        if ($validation->passed()) {
            if ($this->user()->password !== Utility\Hash::generate($this->param("current_password"), $this->user()->salt)) {
                $this->flash("danger", $this->text("user/password_invalid"));
            } else {
                $this->user()->update([
                    "salt" => ($salt = Utility\Hash::generateSalt(32)),
                    "password" => Utility\Hash::generate($this->param("new_password"), $salt)
                ]);
                $this->flash("success", $this->text("user/password_updated"));
            }
        }
        return($this->redirect("user.password"));
    }

    /**
     * Post Profile:
     */
    public function postProfile() {
        $validation = $this->validate([
            "forename" => v::max(100)->notEmpty()->noWhitespace()->alpha(),
            "surname" => v::max(100)->notEmpty()->noWhitespace()->alpha()
        ]);
        if ($validation->passed()) {
            $this->user()->update([
                "forename" => $this->param("forename"),
                "surname" => $this->param("surname")
            ]);
            $this->flash("success", $this->text("user/profile_updated"));
        }
        return($this->redirect("user.profile"));
    }

}
