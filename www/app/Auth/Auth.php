<?php

namespace App\Auth;

use App\Model\User;
use App\Utility\Session;

class Auth {

    /** @var type  */
    private $_sessionName;

    /**
     * 
     */
    public function __construct($sessionName) {
        $this->_sessionName = $sessionName;
    }

    /**
     * 
     */
    public function check() {
        return(Session::exists($this->_sessionName));
    }

    /**
     * 
     */
    public function user() {
        return(User::find(Session::get($this->_sessionName)));
    }

}
