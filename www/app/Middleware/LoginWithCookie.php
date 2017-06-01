<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Model\User;
use App\Model\UserCookie;
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
        $cookieName = $this->container->config->get("cookies/user_remember");
        $sessionName = $this->container->config->get("sessions/user_id");
        if (!Session::exists($sessionName) and Cookie::exists($cookieName)) {
            $cookie = UserCookie::where("hash", Cookie::get($cookieName))->first();
            if ($cookie and User::find($cookie->user_id)) {
                Session::put($sessionName, $cookie->user_id);
            } else {
                UserCookie::destroy($cookie->id);
                Cookie::delete($cookieName);
            }
        }
        return $next($request, $response);
    }

}
