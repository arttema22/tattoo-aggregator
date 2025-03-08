<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\SalonSelectionRequest
 *
 * @property int $id
 * @property array $types
 * @property int $city_id
 * @property string $phone
 * @property string $description
 * @property int $is_mail_sent
 * @property int|null $landing_page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\File|null $file
 * @property-read \App\Models\LandingPage|null $landingPage
 * @method static \Database\Factories\SalonSelectionRequestFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereIsMailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereLandingPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalonSelectionRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SalonSelectionRequest extends Model
{
    use HasFactory,
        Filterable;

    public $fillable = [
        'types',
        'city_id',
        'phone',
        'description',
        'is_mail_sent',
        'landing_page_id',
    ];

    protected $hidden = [
        'city_id',
        'landing_page_id',
    ];

    protected $casts = [
        'types' => 'array',
    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo( City::class );
    }

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo( LandingPage::class );
    }

    public function file(): MorphOne
    {
        return $this->morphOne( File::class, 'fileable' );
    }
}
