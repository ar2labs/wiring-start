<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class User
 *
 * @mixin \Illuminate\Database\Query\Builder
 */
class User extends EloquentModel
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
     * @var array<string>
     */
    protected $fillable = [
        'username', 'email', 'password', 'active', 'active_hash',
        'remember_identifier', 'remember_token', 'recover_hash',
    ];

    /**
     * The attributes that are hidden.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password', 'active_hash', 'remember_identifier',
        'remember_token', 'recover_hash',
    ];

    /**
     * Update remember credentials.
     *
     * @param string $identifier
     * @param string $token
     *
     * @return void
     */
    public function updateRememberCredentials(string $identifier, string $token)
    {
        $this->update([
            'remember_identifier' => $identifier,
            'remember_token' => $token,
        ]);
    }

    /**
     * Remove remember credentials.
     *
     * @return void
     */
    public function removeRememberCredentials()
    {
        $this->updateRememberCredentials('', '');
    }

    /**
     * Get user role.
     *
     * @return HasOne
     */
    public function userRole()
    {
        return $this->hasOne('\App\Model\UserRole', 'user_id');
    }

    /**
     * Check has role.
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role)
    {
        if (!($this->userRole() instanceof HasOne)) {
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
