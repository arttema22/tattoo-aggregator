<?php

namespace App\Models;

use App\Filters\ServiceFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property int $profile_id
 * @property string $name
 * @property int $type
 * @property string $price
 * @property string $currency
 * @property int $is_start_price
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $contact_id
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\Profile|null $profile
 * @method static \Illuminate\Database\Eloquent\Builder|Service defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ServiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Service filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Service filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Service filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Service filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIsStartPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    protected $fillable = [
        'name',
        'type',
        'price',
        'currency',
        'is_start_price',
        'status',
        'profile_id',
        'contact_id',
    ];

    protected $hidden = [
        'profile_id',
        'created_at',
        'updated_at'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo( Profile::class );
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo( Contact::class );
    }
}
