<?php

namespace App\Model;

use App\Core\Model;

class UserRole extends Model {
    
    protected $table = "user_roles";
    protected $fillable = ["role_id", "user_id"];

}
