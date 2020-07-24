<?php

namespace App\Model;

use Closure;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static static             create(array $attributes = [])
 * @method static static|null        find(mixed $id, array $columns = ['*'])
 * @method static static|null        first(array $columns = ['*'])
 * @method static static             firstOrFail(array $columns = ['*'])
 * @method static Collection<static> get(array $columns = ['*'])
 * @method static static             where(string|array|Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static static             orderBy(string $column, string $direction = 'asc')
 */
class EloquentModel extends Model
{
    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var bool $incrementing
     */
    public $incrementing = false;
}
