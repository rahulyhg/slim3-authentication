<?php

namespace App\Model;

use App\Core\Model;

class UserCookie extends Model {

    protected $table = "user_cookies";
    protected $fillable = [
        "hash",
        "user_id"
    ];

}
