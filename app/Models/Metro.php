<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Metro
 *
 * @property int $id
 * @property int $city_id
 * @property int $line_id
 * @property array $name
 * @property float|null $lat
 * @property float|null $lon
 * @property int $position
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\LineMetro|null $line
 * @method static \Illuminate\Database\Eloquent\Builder|Metro defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\MetroFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Metro filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Metro query()
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereLineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Metro wherePosition($value)
 * @mixin \Eloquent
 */
class Metro extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    protected $table = 'metro';

    public $timestamps = false;

    protected $fillable = [
        'city_id',
        'line_id',
        'name',
        'lat',
        'lon',
    ];

    protected $hidden = [
        'city_id',
        'line_id',
    ];

    protected $casts = [
        'name' => 'array'
    ];

    public function city() : BelongsTo
    {
        return $this->belongsTo( City::class );
    }

    public function line() : BelongsTo
    {
        return $this->belongsTo( LineMetro::class );
    }
}
