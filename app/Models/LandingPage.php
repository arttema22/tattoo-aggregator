<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\LandingPage
 *
 * @property int $id
 * @property string $slug
 * @property int $city_id
 * @property int $type
 * @property array $dictionary
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string|null $caption
 * @property string $seo_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandingPageTag[] $landingPageTags
 * @property-read int|null $landing_page_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandingPageUserTag[] $landingPageUserTags
 * @property-read int|null $landing_page_user_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalonSelectionRequest[] $salonSelectionRequests
 * @property-read int|null $salon_selection_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandingPageService[] $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\LandingPageFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereDictionary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandingPage extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    public $fillable = [
        'slug',
        'city_id',
        'type',
        'dictionary',
        'title',
        'keywords',
        'caption',
        'description',
        'seo_text',
    ];

    protected $hidden = [
        'city_id',
    ];

    protected $casts = [
        'dictionary' => 'array',
    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo( City::class );
    }

    public function landingPageTags(): HasMany
    {
        return $this->hasMany( LandingPageTag::class, 'landing_page_id', 'id' );
    }

    public function landingPageUserTags(): HasMany
    {
        return $this->hasMany( LandingPageUserTag::class, 'landing_page_id', 'id' );
    }

    public function salonSelectionRequests(): HasMany
    {
        return $this->hasMany( SalonSelectionRequest::class );
    }

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany( Review::class, 'landing_page_reviews' );
    }

    public function services(): HasMany
    {
        return $this->hasMany( LandingPageService::class, 'landing_page_id', 'id' );
    }
}
