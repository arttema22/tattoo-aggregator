<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\LandingPageUserTag
 *
 * @property int $id
 * @property int $landing_page_id
 * @property string $name
 * @property string $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LandingPage|null $landingPage
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag whereLandingPageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPageUserTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LandingPageUserTag extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    public $fillable = [
        'landing_page_id',
        'name',
        'link'
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
