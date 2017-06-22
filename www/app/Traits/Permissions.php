<?php

namespace App\Traits;

use App\Model\Role;

trait Permissions {

    public function hasRole($roles) {
        if (!is_array($roles)) {
            $roles = (array) $roles;
        }
        foreach ($roles as $role) {
            if ($this->roles->contains("name", $role)) {
                return true;
            }
        }
        return false;
    }

    public function roles() {
        return($this->belongsToMany(Role::class, "user_roles", "user_id"));
    }

}
