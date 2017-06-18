<?php

namespace App\Controller\Auth;

use App\Core\Controller;
use App\Utility\Cookie;
use App\Utility\Session;

class Logout extends Controller {
    
    public function get(){
        Session::destroy();
        $key = $this->config("cookies/user_remember");
        if (Cookie::exists($key)) {
            $user = $this->auth()->user();
            if ($user->removeRememberCredentials()) {
                Cookie::delete($key);
            }
        }
        return($this->redirect("auth.login"));
    }
    
}
