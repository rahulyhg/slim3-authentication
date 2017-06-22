<?php

namespace App\Model;

use App\Core\Model;

class Role extends Model {

    protected $table = "roles";
    protected $fillable = ["description", "name"];

}
