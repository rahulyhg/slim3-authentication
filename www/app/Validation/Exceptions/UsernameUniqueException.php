<?php

namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class UsernameUniqueException extends ValidationException {

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => "Username is already taken.",
        ],
    ];

}
