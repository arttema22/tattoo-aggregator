<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\FilterPage
 *
 * @property int $id
 * @property int $type
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property array $dictionary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereDictionary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FilterPage extends Model
{
    use Filterable,
        AsSource,
        OrchidFilterable;

    protected $fillable = [
        'type',
        'slug',
        'title',
        'description',
        'keywords',
        'dictionary',
    ];

    protected $casts = [
        'dictionary' => 'array',
    ];
}
