<?php

namespace App\Controller\Admin;

use App\Core\Controller;
use App\Model\User;
use Respect\Validation\Validator as v;

class Users extends Controller {

    public function getCreate() {
        return($this->render("admin/users/create.twig"));
    }

    public function getDelete($userId) {
        return($this->render("admin/users/delete.twig"));
    }

    public function getUpdate($userId) {
        return($this->render("admin/users/update.twig"));
    }

    public function postCreate() {
        $validation = $this->validate([
            "username" => v::max(32)->notEmpty()->noWhitespace()->alnum()->usernameUnique(),
            "email" => v::max(254)->notEmpty()->noWhitespace()->email()->emailUnique(),
            "activated" => v::notEmpty(),
            "password" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("password_repeat")),
            "password_repeat" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("password")),
            "forename" => v::max(100)->notEmpty()->noWhitespace()->alpha(),
            "surname" => v::max(100)->notEmpty()->noWhitespace()->alpha(),
            "biography" => v::max(160),
            "location" => v::max(32),
            "website" => v::max(100)->url()
        ]);
        if ($validation->passed()) {
            $salt = $this->hash()->salt(32);
            $activated = $this->param("activated") === "true";
            $activationCode = $activated ? "" : $this->hash()->unique();
            $user = User::create([
                "activated" => $activated,
                "activation_code" => $activationCode,
                "biography" => $this->param("biography"),
                "email" => $this->param("email"),
                "forename" => $this->param("forename"),
                "location" => $this->param("location"),
                "password" => $this->hash()->generate($this->param("password") . $salt),
                "surname" => $this->param("surname"),
                "username" => $this->param("username"),
                "website" => $this->param("website"),
                "salt" => $salt
            ]);
            if (!$activated) {
                // send email
                $this->flash("info", $this->text(""));
            }
            $this->flash("success", $this->text(""));
            return($this->redirect("admin.users.update", ["userId" => $user->id]));
        }
        return($this->redirect("admin.users.create"));
    }

    public function postDelete($userId) {
        
    }

    public function postUpdate($userId) {
        
    }

}
