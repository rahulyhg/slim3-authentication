<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Model\User;
use App\Utility\Cookie;
use App\Utility\Session;

/**
 * 
 */
class LoginWithCookie extends Middleware {

    /**
     * 
     */
    public function handle($request, $response, $next) {
        $key = $this->config("cookies/user_remember");
        if (Cookie::exists($key) and ! $this->auth()->check()) {
            $hash = Cookie::get($key);
            $credentials = explode(".", $hash);
            if (empty(trim($hash)) or count($credentials) !== 2) {
                Cookie::delete($key);
                return $this->redirect($response, "index");
            }
            $rememberIdentifier = $credentials[0];
            $user = User::where("remember_identifier", $rememberIdentifier)->first();
            if ($user) {
                $rememberToken = $this->hash()->generate($credentials[1]);
                if ($rememberToken === $user->remember_token) {
                    Session::put($this->config("sessions/user_id"), $user->id);
                } else {
                    $user->removeRememberCredentials();
                }
            }
        }
        $response = $next($request, $response);
        return $response;
    }

}
