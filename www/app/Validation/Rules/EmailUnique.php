<?php

namespace App\Validation\Rules;

use App\Model\User;
use Respect\Validation\Rules\AbstractRule;

class EmailUnique extends AbstractRule {
    
    private $_email;
    
    public function __construct($email = "") {
        $this->_email = $email;
    }
    
    public function validate($input) {
        if ($this->_email and $this->_email === $input) {
            return true;
        }
        return(User::where("email", $input)->count() === 0);
    }

}
