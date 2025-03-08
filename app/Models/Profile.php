<?php

namespace App\Models;

use App\Enums\FileSubtypes;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $approved
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdditionalService[] $additionalServices
 * @property-read int|null $additional_services_count
 * @property-read \App\Models\File|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \App\Models\File|null $cover
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SocialNetwork[] $socialNetworks
 * @property-read int|null $social_networks_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read int|null $videos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Profile defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ProfileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Profile filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Profile whereUserId($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    protected $fillable = [
        'type',
        'name',
        'description',
        'approved'
    ];

    protected $hidden = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    public function contacts(): HasMany
    {
        return $this->hasMany( Contact::class );
    }

    public function additionalServices(): HasMany
    {
        return $this->hasMany( AdditionalService::class );
    }

    public function socialNetworks(): HasMany
    {
        return $this->hasMany( SocialNetwork::class );
    }

    public function services(): HasMany
    {
        return $this->hasMany( Service::class );
    }

    public function cover() : MorphOne
    {
        return $this->morphOne( File::class, 'fileable' )->where( 'fileable_subtype', FileSubtypes::COMMON );
    }

    public function avatar() : MorphOne
    {
        return $this->morphOne( File::class, 'fileable' )->where( 'fileable_subtype', FileSubtypes::PROFILE_AVATAR );
    }

    public function videos() : HasMany
    {
        return $this->hasMany( Video::class );
    }
}
