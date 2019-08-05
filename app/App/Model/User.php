<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @mixin \Illuminate\Database\Query\Builder
 */
class User extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'active', 'active_hash',
        'remember_identifier', 'remember_token', 'recover_hash',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'active_hash', 'remember_identifier',
        'remember_token', 'recover_hash',
    ];

    /**
     * Update remember credentials.
     *
     * @param $identifier
     * @param $token
     */
    public function updateRememberCredentials($identifier, $token)
    {
        $this->update([
            'remember_identifier' => $identifier,
            'remember_token' => $token,
        ]);
    }

    /**
     * Remove remember credentials.
     */
    public function removeRememberCredentials()
    {
        $this->updateRememberCredentials('', '');
    }

    /**
     * Get user role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userRole()
    {
        return $this->hasOne('\App\Model\UserRole', 'user_id');
    }

    /**
     * Check has role.
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (!$this->userRole()) {
            return false;
        }

        return (bool) $this->userRole()->{$role};
    }

    /**
     * Check user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('is_admin');
    }
}
