<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\City
 *
 * @property int $id
 * @property int $country_id
 * @property string $alias
 * @property array $name
 * @property int $has_metro
 * @property int $show_in_filter
 * @property int $population
 * @property float|null $lat
 * @property float|null $lon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Metro[] $metro
 * @property-read int|null $metro_count
 * @method static \Illuminate\Database\Eloquent\Builder|City defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\CityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|City filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|City filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|City filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|City filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereHasMetro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City wherePopulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereShowInFilter($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    public $fillable = [
        'country_id',
        'alias',
        'name',
        'has_metro',
        'show_in_filter',
        'population',
        'lat',
        'lon',
    ];

    protected $table = 'cities';

    public $timestamps = false;

    protected $hidden = [
        'country_id'
    ];

    public $casts = [
        'name' => 'array'
    ];

    protected array $allowedSorts = [
        'has_metro',
        'show_in_filter'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo( Country::class );
    }

    public function contacts(): HasMany
    {
        return $this->hasMany( Contact::class );
    }

    public function metro() : HasMany
    {
        return $this->hasMany( Metro::class );
    }
}
