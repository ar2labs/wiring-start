<?php

namespace App\Model;

use Closure;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static static                  create(array<string, mixed> $attributes = [])
 * @method static static|null             find(mixed $id, array<int, string> $columns = ['*'])
 * @method static static|null             first(array<int, string> $columns = ['*'])
 * @method static static                  firstOrFail(array<int, string> $columns = ['*'])
 * @method static Collection<int, static> get(array<int, string> $columns = ['*'])
 * @method static static                  where(string|array<string, mixed>|Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
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
