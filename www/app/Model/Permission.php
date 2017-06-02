<?php

namespace App\Model;

use App\Core\Model;

class Permission extends Model {

    protected $table = "permissions";
    protected $fillable = ["description", "name"];

}
