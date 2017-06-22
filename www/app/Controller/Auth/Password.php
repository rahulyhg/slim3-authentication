<?php

namespace App\Controller\Auth;

use App\Core\Controller;

class Password extends Controller {

    public function getForgot() {
        return($this->render("auth/password/forgot.twig"));
    }

    public function getReset() {
        return($this->render("auth/password/reset.twig"));
    }

    public function postForgot() {
        
    }

    public function postReset() {
        
    }

}
