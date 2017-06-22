<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\User;

/**
 * 
 */
class Profile extends Controller {

    /**
     * 
     */
    public function getProfile($username) {
        $user = User::where("username", $username)->first();
        if (!$user) {
            return($this->redirect("index"));
        }
        return($this->render("profile/profile.twig", ["user" => $user]));
    }

}
