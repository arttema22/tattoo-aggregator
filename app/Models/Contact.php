<?php

namespace App\Models;

use App\Enums\FileSubtypes;
use App\Filters\ContactFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $country_id
 * @property int|null $city_id
 * @property int $metro_id
 * @property string $alias
 * @property string $name
 * @property string|null $description
 * @property string $address
 * @property string $phone
 * @property string $site
 * @property string $email
 * @property string $district
 * @property float|null $lat
 * @property float|null $lon
 * @property int $filled_percent
 * @property int $additional_filled_percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdditionalService[] $additionalServices
 * @property-read int|null $additional_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Album[] $albums
 * @property-read int|null $albums_count
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\File|null $cover
 * @property-read int $filled
 * @property-read \App\Models\Metro|null $metro
 * @property-read \App\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalonDistance[] $salonDistances
 * @property-read int|null $salon_distances_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Contact[] $siblings
 * @property-read int|null $siblings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SocialNetwork[] $socialNetworks
 * @property-read int|null $social_networks_count
 * @property-read \App\Models\AggSpecialization|null $specialization
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read int|null $videos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkingHours[] $workingHours
 * @property-read int|null $working_hours_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contact defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ContactFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Query\Builder|Contact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAdditionalFilledPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereFilledPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMetroId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Contact withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Contact withoutTrashed()
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use HasFactory,
        Filterable,
        SoftDeletes,
        AsSource,
        OrchidFilterable;

    protected $fillable = [
        'country_id',
        'city_id',
        'metro_id',
        'alias',
        'name',
        'description',
        'address',
        'district',
        'metro',
        'phone',
        'site',
        'email',
        'lat',
        'lon',
        'filled_percent',
        'additional_filled_percent'
    ];

    protected $hidden = [
        'profile_id',
        'country_id',
        'city_id',
        'metro_id',
    ];

    protected $allowedSorts = [
        'created_at',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo( Profile::class );
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo( Country::class );
    }

    public function metro(): BelongsTo
    {
        return $this->belongsTo( Metro::class );
    }

    public function workingHours(): HasMany
    {
        return $this->hasMany( WorkingHours::class );
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo( City::class );
    }

    public function cover() : MorphOne
    {
        return $this->morphOne( File::class, 'fileable' )->where( 'fileable_subtype', FileSubtypes::COMMON );
    }

    public function albums(): HasMany
    {
        return $this->hasMany( Album::class );
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo( AggSpecialization::class, 'id', 'contact_id' );
    }

    public function additionalServices(): HasMany
    {
        return $this->hasMany( AdditionalService::class );
    }

    public function services(): HasMany
    {
        return $this->hasMany( Service::class );
    }

    public function socialNetworks(): HasMany
    {
        return $this->hasMany( SocialNetwork::class );
    }

    public function reviews() : HasMany
    {
        return $this->hasMany( Review::class, 'contact_id', 'id' );
    }

    public function videos() : HasMany
    {
        return $this->hasMany( Video::class, 'contact_id', 'id' );
    }

    public function salonDistances(): HasMany
    {
        return $this->hasMany( SalonDistance::class, 'salon_id', 'id' );
    }

    /**
     * @return HasMany
     */
    public function siblings() : HasMany
    {
        return $this->hasMany( Contact::class, 'profile_id', 'profile_id' )->where( 'id', '!=', $this->id );
    }

    public function getFilledAttribute() : int
    {
        return ($this->attributes[ 'filled_percent' ] ?? 0) + ($this->attributes[ 'additional_filled_percent' ] ?? 0);
    }
}
