<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $alias
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    public $timestamps = false;

    public $fillable = [
        'alias',
        'name',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany( Article::class, 'article_to_category' );
    }
}
