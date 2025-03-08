<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\File
 *
 * @property int $id
 * @property int $user_id
 * @property string $fileable_type
 * @property int $fileable_id
 * @property int $fileable_subtype
 * @property string $original
 * @property array $thumbs
 * @property int $size
 * @property string $mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Album|null $album
 * @property-read \App\Models\FileInfo|null $fileInfo
 * @property-read Model|\Eloquent $fileable
 * @property-read string|null $url
 * @method static \Illuminate\Database\Eloquent\Builder|File defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\FileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|File filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|File filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|File filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|File filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Query\Builder|File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereThumbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|File withoutTrashed()
 * @mixin \Eloquent
 */
class File extends Model
{
    use HasFactory,
        Filterable,
        SoftDeletes,
        AsSource,
        OrchidFilterable;

    protected $fillable = [
        'original',
        'thumbs',
        'size',
        'mime_type',
    ];

    protected $hidden = [
        'user_id',
        'updated_at',
        'created_at',
        'deleted_at',
        'fileable_type',
        'fileable_id',
        'fileable_subtype',
    ];

    protected $casts = [
        'thumbs' => 'array'
    ];

    public function fileInfo(): HasOne
    {
        return $this->hasOne( FileInfo::class );
    }

    public function album()
    {
        return $this->hasOne( Album::class, 'id', 'fileable_id' );
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute() : ?string
    {
        return '/storage/images/original/' . $this->attributes[ 'original' ];
    }

    /*public function url() : ?string
    {
        return '/storage/images/original/' . $this->original;
    }*/
}
