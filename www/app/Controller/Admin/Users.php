<?php

namespace App\Controller\Admin;

use App\Core\Controller;

class Users extends Controller {

    public function getCreate() {
        return($this->render("admin/users/create.twig"));
    }

    public function getDelete($userId) {
        return($this->render("admin/users/delete.twig"));
    }

    public function getUpdate($userId) {
        return($this->render("admin/users/update.twig"));
    }

    public function postCreate() {
        
    }

    public function postDelete($userId) {
        
    }

    public function postUpdate($userId) {
        
    }

}
