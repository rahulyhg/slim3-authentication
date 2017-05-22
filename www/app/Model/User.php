<?php

namespace App\Model;

use App\Core\Model;

class User extends Model {

    protected $table = "users";
    protected $fillable = [
        "salt",
        "email",
        "forename",
        "password",
        "surname",
        "username"
    ];

}
