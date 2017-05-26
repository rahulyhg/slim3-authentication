<?php

namespace App\Auth;

use App\Model\User;
use App\Utility\Hash;
use App\Utility\Session;

class Auth {

    public function check() {
        return(Session::exists("user_id"));
    }

    public function login($emailOrUsername, $password) {
        $user = User::where("email", $emailOrUsername)->orWhere("username", $emailOrUsername)->first();

        if (!$user) {
            return false;
        }

        if ($user->password !== Hash::generate($password, $user->salt)) {
            return false;
        }

        Session::put("user_id", $user->id);

        return true;
    }

    public function logout() {
        Session::destroy();
    }

    public function user() {
        return(User::find(Session::get("user_id")));
    }

}
