<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Log
 *
 * @mixin \Illuminate\Database\Query\Builder
 */
class Log extends EloquentModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'feedback', 'created_at'];

    /**
     * The attributes that are hidden.
     *
     * @var array<int, string>
     */
    protected $hidden = ['id'];

    /**
     * Return user.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Model\User');
    }
}
