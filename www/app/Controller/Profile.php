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
    public function getProfile($request, $response, $args) {
        $user = User::where("username", $args["username"])->first();
        if (!$user) {
            return($response->withRedirect($this->router->pathFor("index")));
        }
        return($this->container->view->render($response, "profile/profile.twig", ["user" => $user]));
    }

}
