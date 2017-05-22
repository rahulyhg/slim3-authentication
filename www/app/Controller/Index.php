<?php

namespace App\Controller;

use App\Core\Controller as BaseController;

class Index extends BaseController {
    
    public function index($request, $response) {
        return $this->container->view->render($response, "index/index.twig");
    }
    
}
