<?php

namespace App\Models;

use App\Filters\SocialNetworkFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\SocialNetwork
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property int $sn_id
 * @property string $value
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Profile|null $profile
 * @property-read \App\Models\SocialNetworkName|null $socialNetworkName
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\SocialNetworkFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereSnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetwork whereValue($value)
 * @mixin \Eloquent
 */
class SocialNetwork extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    protected $fillable = [
        'contact_id',
        'sn_id',
        'value',
        'status'
    ];

    protected $hidden = [
        'profile_id',
        'contact_id'
    ];

    public function socialNetworkName(): BelongsTo
    {
        return $this->belongsTo( SocialNetworkName::class, 'sn_id' );
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo( Profile::class );
    }
}
