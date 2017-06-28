<?php

namespace App\Controller\Auth;

use App\Core\Controller;
use App\Model\User;
use Respect\Validation\Validator as v;

class Password extends Controller {

    public function getForgot() {
        return($this->render("auth/password/forgot.twig"));
    }

    public function getReset() {
        $recoverHash = $this->param("recover_hash");
        if (!$recoverHash) {
            return($this->redirect("auth.login"));
        }
        return($this->render("auth/password/reset.twig", ["recover_hash" => $recoverHash]));
    }

    public function postForgot() {
        $validation = $this->validate([
            "email_or_username" => v::notEmpty()
        ]);
        if ($validation->passed()) {
            $emailOrUsername = $this->param("email_or_username");
            $user = User::where("email", $emailOrUsername)->orWhere("username", $emailOrUsername)->first();
            if ($user) {
                $user->update([
                    "recover_hash" => ($recoverHash = $this->hash()->unique()),
                ]);
            }
            $this->flash("success", $this->text("user/forgot_password_success"));
            return($this->redirect("auth.login"));
        }
        return($this->redirect("auth.password.forgot"));
    }

    public function postReset() {
        $validation = $this->validate([
            "email_or_username" => v::notEmpty(),
            "new_password" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("new_password_repeat")),
            "new_password_repeat" => v::max(8)->notEmpty()->noWhitespace()->identical($this->param("new_password"))
        ]);
        $recoverHash = $this->param("recover_hash");
        if ($validation->passed() and $recoverHash) {
            $emailOrUsername = $this->param("email_or_username");
            $user = User::where("email", $emailOrUsername)->orWhere("username", $emailOrUsername)->first();
            if ($user) {
                $recoverHash = $this->param("recover_hash");
                if ($recoverHash === $user->recover_hash) {
                    $user->update([
                        "recover_hash" => "",
                        "salt" => ($salt = $this->hash()->salt(32)),
                        "password" => $this->hash()->generate($this->param("new_password"), $salt)
                    ]);
                    $this->flash("success", $this->text("user/reset_password_success"));
                    return($this->redirect("auth.login"));
                }
                $user->update([
                    "recover_hash" => ""
                ]);
                $this->flash("danger", $this->text("user/reset_password_failed"));
            }
        }
        return($this->redirect("auth.password.forgot"));
    }

}
