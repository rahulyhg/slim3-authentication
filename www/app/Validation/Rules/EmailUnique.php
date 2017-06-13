<?php

namespace App\Validation\Rules;

use App\Model\User;
use Respect\Validation\Rules\AbstractRule;

class EmailUnique extends AbstractRule {
    
    private $_auth;
    
    public function __construct($auth) {
        $this->_auth = $auth;
    }

    public function validate($input) {
        if ($this->_auth->check() and $this->_auth->user()->email === $input) {
            return true;
        }
        return(User::where("email", $input)->count() === 0);
    }

}
