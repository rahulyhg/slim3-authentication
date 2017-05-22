<?php

namespace App\Controller;

use App\Core\Controller as BaseController;

class User extends BaseController {
    
    public function profile($request, $response, $args) {
        return $this->container->view->render($response, "user/profile.twig");
    }
    
    
}
