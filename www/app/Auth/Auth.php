<?php

namespace App\Auth;

use App\Model\User;
use App\Utility\Hash;
use App\Utility\Session;

class Auth {

    public function check() {
        return(Session::exists("user_id"));
    }

    public function login($email, $password, $remember = false) {
        $user = User::where('email', $email)->first();

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
