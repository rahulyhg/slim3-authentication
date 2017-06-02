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

    public function getRoles() {
        return($this->hasMany(UserRole::class, "user_id"));
    }

    public function giveRole($roleId) {
        if (!$role = Role::find($roleId)) {
            return false;
        }
        $userRoles = $this->getRoles();
        if ($userRoles->where("role_id", $role->id)->first()) {
            return true;
        }
        return $this->getRoles()->create(["role_id" => $role->id]);
    }

    public function isAdmin() {
        //return $this->hasRole("admin");
    }

    public function isSuperAdmin() {
        //return $this->hasRole("superadmin");
    }

    public function removeRole($roleId) {
        if (!$role = Role::find($roleId)) {
            return false;
        }
        $userRole = $this->getRoles()->where("role_id", $role->id)->first();
        if ($userRole) {
            return $userRole->delete();
        }
        return false;
    }

}
