<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\LineMetro
 *
 * @property int $id
 * @property array $name
 * @property string $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Metro[] $metro
 * @property-read int|null $metro_count
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\LineMetroFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro query()
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LineMetro whereName($value)
 * @mixin \Eloquent
 */
class LineMetro extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    protected $table = 'line_metro';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'color'
    ];

    protected $casts = [
        'name' => 'array'
    ];

    public function metro() : HasMany
    {
        return $this->hasMany( Metro::class, 'line_id', 'id' );
    }
}
