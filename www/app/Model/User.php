<?php

namespace App\Model;

use App\Core\Model;
use App\Traits\Permissions;


/**
 * 
 */
class User extends Model {
    
    use Permissions;

    /** @var string */
    protected $table = "users";

    /** @var array */
    protected $fillable = [
        "activated",
        "activation_code",
        "biography",
        "email",
        "forename",
        "location",
        "password",
        "recover_hash",
        "remember_token",
        "remember_identifier",
        "salt",
        "surname",
        "username",
        "website"
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
        return($this->hasRole("Admin"));
    }

    /**
     * 
     */
    public function isSuperAdmin() {
        return($this->hasRole("Super Admin"));
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
