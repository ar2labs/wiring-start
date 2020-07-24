<?php

namespace App\Model;

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
     * @var array<string>
     */
    protected $fillable = ['user_id', 'feedback', 'created_at'];

    /**
     * The attributes that are hidden.
     *
     * @var array<string>
     */
    protected $hidden = ['id'];

    /**
     * Return user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
