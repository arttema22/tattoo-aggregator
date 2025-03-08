<?php

namespace App\Models;

use App\Filters\VideoFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Video
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property string $url
 * @property string|null $preview
 * @property string $name
 * @property string $text
 * @property string $html
 * @property array $meta
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\File|null $cover
 * @property-read \App\Models\Profile|null $profile
 * @method static \Illuminate\Database\Eloquent\Builder|Video defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\VideoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Video filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Video filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Video filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Video filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video wherePreview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUrl($value)
 * @mixin \Eloquent
 */
class Video extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    protected $fillable = [
        'url',
        'profile_id',
        'contact_id',
        'preview',
        'name',
        'text',
        'html',
        'meta',
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    public const UPDATED_AT = null;

    protected $hidden = [
        'profile_id',
        'contact_id',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo( Profile::class );
    }

    public function contact(): HasOne
    {
        return $this->hasOne( Contact::class, 'id', 'contact_id' );
    }

    public function cover() : MorphOne
    {
        return $this->morphOne( File::class, 'fileable' );
    }
}
