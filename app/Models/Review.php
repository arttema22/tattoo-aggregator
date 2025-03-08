<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Review
 *
 * @property int $id
 * @property int $contact_id
 * @property string $name
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $type
 * @property int $is_approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LandingPage[] $landingPage
 * @property-read int|null $landing_page_count
 * @method static \Illuminate\Database\Eloquent\Builder|Review defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\ReviewFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Review filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Review filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Review filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Review filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    public $fillable = [
        'contact_id',
        'name',
        'content',
        'published_at',
        'type'
    ];

    public $dates = [
        'created_at',
        'published_at',
        'updated_at',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo( Contact::class );
    }

    public function landingPage(): BelongsToMany
    {
        return $this->belongsToMany( LandingPage::class, 'landing_page_reviews' );
    }
}
