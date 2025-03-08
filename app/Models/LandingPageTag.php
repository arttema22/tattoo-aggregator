<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\LandingPageTag
 *
 * @property int $id
 * @property int $landing_page_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandingPage|null $landingPage
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\LandingPageTagFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag whereLandingPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandingPageTag extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    public $fillable = [
        'landing_page_id',
        'name',
    ];

    protected $hidden = [
        'landing_page_id',
    ];

    public $dates = [
        'created_at',
        'updated_at',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo( LandingPage::class );
    }
}
