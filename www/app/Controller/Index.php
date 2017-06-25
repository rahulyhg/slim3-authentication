<?php

namespace App\Controller;

use App\Core\Controller;

class Index extends Controller {

    public function getIndex() {
        return($this->render("index/index.twig"));
    }

}
