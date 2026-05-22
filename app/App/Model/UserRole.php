<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Class UserRole
 *
 * @mixin \Illuminate\Database\Query\Builder
 */
class UserRole extends EloquentModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_roles';

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array<int, string>
     */
    protected $fillable = ['is_admin'];

    /**
     * @var array<string, bool|string>
     */
    public static $defaults = [
        'is_admin' => false,
        'created_at' => '',
    ];
}
