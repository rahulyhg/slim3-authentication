<?php

namespace App\Core;

use App\Model;
use App\Utility;

/**
 * 
 */
class Auth {

    /**
     * 
     */
    public function check() {
        return(Utility\Session::exists("user_id"));
    }
    
    /**
     * 
     */
    public function user() {
        return(Model\User::find(Utility\Session::get("user_id")));
    }

}
