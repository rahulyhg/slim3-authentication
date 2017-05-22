<?php

namespace App\Validation\Rules;

use App\Model\User;
use Respect\Validation\Rules\AbstractRule;

class EmailUnique extends AbstractRule {

    public function validate($input) {
        return(User::where("email", $input)->count() === 0);
    }

}
