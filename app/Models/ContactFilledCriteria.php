<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContactFilledCriteria
 *
 * @property int $id
 * @property int $type
 * @property int|null $subtype
 * @property int|null $value
 * @property int $percent
 * @method static \Database\Factories\ContactFilledCriteriaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFilledCriteria whereValue($value)
 * @mixin \Eloquent
 */
class ContactFilledCriteria extends Model
{
    use HasFactory, Filterable;

    protected $table = 'contact_filled_criteria';
    public $timestamps = false;
}
