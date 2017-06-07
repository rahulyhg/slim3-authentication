<?php

namespace App\Controller;

use App\Core;

class Admin extends Core\Controller {

    public function getIndex() {
        $this->render("admin/index.twig");
    }

}
