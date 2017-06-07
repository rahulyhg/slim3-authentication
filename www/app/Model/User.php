<?php

namespace App\Model;

use App\Core;

/**
 * 
 */
class User extends Core\Model {

    /** @var string */
    protected $table = "users";

    /** @var array */
    protected $fillable = [
        "salt",
        "email",
        "forename",
        "password",
        "remember_token",
        "remember_identifier",
        "surname",
        "username"
    ];

    /**
     * 
     */
    public function getRoles() {
        return($this->hasMany(UserRole::class, "user_id"));
    }

    /**
     * 
     */
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

    /**
     * 
     */
    public function isAdmin() {
        return true;
    }

    /**
     * 
     */
    public function isSuperAdmin() {
        return true;
    }

    /**
     * 
     */
    public function updateRememberCredentials($identifier, $token) {
        return $this->update([
            "remember_identifier" => $identifier,
            "remember_token" => $token
        ]);
    }

    public function removeRememberCredentials() {
        return $this->updateRememberCredentials(null, null);
    }

    /**
     * 
     */
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
