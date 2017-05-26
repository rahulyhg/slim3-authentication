<?php

namespace App\Controller;

use App\Core\Controller;

/**
 * 
 */
class Index extends Controller {

    /**
     * 
     */
    public function getIndex($request, $response) {
        return($this->container->view->render($response, "index/index.twig"));
    }

}
