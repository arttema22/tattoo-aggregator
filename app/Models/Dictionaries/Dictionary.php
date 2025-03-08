<?php

namespace App\Models\Dictionaries;

use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Dictionaries\Dictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary defaultSort(string $column, string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dictionary whereType($value)
 * @mixin \Eloquent
 */
class Dictionary extends ADictionary
{
    use AsSource,
        OrchidFilterable;

    public $fillable = [
        'type',
        'slug',
        'name'
    ];
}
