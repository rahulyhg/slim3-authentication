<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Model\User;
use App\Model\UserCookie;
use App\Utility\Cookie;
use App\Utility\Hash;
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
        
        //die($key);
        
        if (Cookie::exists($key) and ! $this->auth()->check()) {
            $hash = Cookie::get($key);
            $credentials = explode(".", $hash);
                        
            if (empty(trim($hash)) or count($credentials) !== 2) {
                die('count: ' . count($credentials));
                Cookie::delete($key);
                return $this->redirect($response, "index");
            }

            die("here2");
            
            $rememberIdentifier = $credentials[0];

            $user = $this->container->auth->where("remember_identifier", $rememberIdentifier)->first();
            if ($user) {
                $rememberToken = Hash::generate($credentials[1]);
                if ($rememberToken === $this->remember_token) {
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
