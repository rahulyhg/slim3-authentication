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
        if (!Session::exists("user") and Cookie::exists("user")) {
            $cookie = UserCookie::where("hash", Cookie::get("user"))->first();
            if ($cookie and User::find($cookie->user_id)) {
                Session::put("user", $cookie->user_id);
            } else {
                UserCookie::destroy($cookie->id);
                Cookie::delete("user");
            }
        }
        return $next($request, $response);
    }

}
