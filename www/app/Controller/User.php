<?php

namespace App\Controller;

use Exception;
use App\Core;
use App\Utility;
use Respect\Validation\Validator;

class User extends Core\Controller {

    public function getAccount() {
        return($this->render("user/account.twig"));
    }

    public function getPassword() {
        return($this->render("user/password.twig"));
    }

    public function getProfile() {
        return($this->render("user/profile.twig"));
    }

    public function postAccount() {

        // 
        $validation = $this->validate([
            "username" => Validator::max(32)->notEmpty()->noWhitespace()->alnum(),
            "email" => Validator::max(254)->notEmpty()->noWhitespace()->email()->emailUnique($this->auth())
        ]);
        
        return($this->redirect("user.account"));

        // 
        if ($validation->passed()) {
            $user = $this->user()->update([]);
            if ($user) {
                $this->flash("success", $this->text(""));
                $this->redirect("");
            }
        }

        //
        $this->flash("danger", $this->text(""));
        $this->redirect("");
    }

    public function postPassword() {

        // 
        $validation = $this->validate([
            "current_password" => Validator::notEmpty()->noWhitespace(),
            "new_password" => Validator::max(8)->notEmpty()->noWhitespace(),
            "new_password_repeat" => Validator::max(8)->notEmpty()->noWhitespace()->identical("new_password")
        ]);

        // 
        if ($validation->passed()) {
            
            // 
            $user = $this->user();
            if ($user->password !== Hash::generate($this->param("current_password"), $user->salt)) {
                $this->flash("danger", $this->text(""));
                return($this->redirect("user.password"));
            }

            //
            $salt = Utility\Hash::generateSalt(32);
            $password = Utility\Hash::generate($this->param("new_password"), $salt);
            if ($user->update(["password" => $password, "salt" => $salt])) {
                $this->flash("success", $this->text(""));
            }
        }

        // 
        return($this->redirect("user.password"));
    }

    public function postProfile() {

        // 
        $validation = $this->validate([
            "forename" => Validator::max(100)->notEmpty()->noWhitespace()->alpha(),
            "surname" => Validator::max(100)->notEmpty()->noWhitespace()->alpha()
        ]);

        // 
        if ($validation->passed()) {
            $user = $this->user()->update([
                "forename" => $this->param("forename"),
                "surname" => $this->param("surname")
            ]);
            if ($user) {
                $this->flash("success", $this->text(""));
            }
        }

        //
        return($this->redirect("user.profile"));
    }

}
