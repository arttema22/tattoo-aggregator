<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SalonDistance
 *
 * @property int $salon_id
 * @property int $salon_nearby_id
 * @property int $distance in meters
 * @property-read \App\Models\Contact|null $salon
 * @property-read \App\Models\Contact|null $salonNearby
 * @method static Builder|SalonDistance filter(\App\Filters\QueryFilter $filter)
 * @method static Builder|SalonDistance newModelQuery()
 * @method static Builder|SalonDistance newQuery()
 * @method static Builder|SalonDistance query()
 * @method static Builder|SalonDistance whereDistance($value)
 * @method static Builder|SalonDistance whereSalonId($value)
 * @method static Builder|SalonDistance whereSalonNearbyId($value)
 * @mixin \Eloquent
 */
class SalonDistance extends Model
{
    use HasFactory, Filterable;

    public $fillable = [
        'salon_id',
        'salon_nearby_id',
        'distance'
    ];

    public $timestamps = false;

    public const PRIMARY_COMPOSITE_KEY = [
        'salon_id',
        'salon_nearby_id'
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo( Contact::class, 'salon_id' );
    }

    public function salonNearby(): BelongsTo
    {
        return $this->belongsTo( Contact::class, 'salon_nearby_id' );
    }
}
