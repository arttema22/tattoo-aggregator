<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\LandingPageService
 *
 * @property int $id
 * @property int $landing_page_id
 * @property int $type
 * @property string $name
 * @property string $price
 * @property string $currency
 * @property bool $is_start_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandingPage|null $landingPage
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\LandingPageServiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService query()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereIsStartPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereLandingPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandingPageService extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    public $fillable = [
        'landing_page_id',
        'type',
        'name',
        'price',
        'currency',
        'is_start_price',
    ];

    protected $casts = [
        'is_start_price' => 'boolean',
    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];

    public function landingPage() : BelongsTo
    {
        return $this->belongsTo( LandingPage::class, 'landing_page_id', 'id' );
    }
}
