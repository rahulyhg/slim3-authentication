<?php

namespace App\Validation\Rules;

use App\Model\User;
use Respect\Validation\Rules\AbstractRule;

class UsernameUnique extends AbstractRule {
    
    private $_username;
    
    public function __construct($username = "") {
        $this->_username = $username;
    }
    
    public function validate($input) {
        if ($this->_username and $this->_username === $input) {
            return true;
        }
        return(User::where("username", $input)->count() === 0);
    }

}
