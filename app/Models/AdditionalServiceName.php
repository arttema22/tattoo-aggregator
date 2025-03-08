<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\AdditionalServiceName
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdditionalService[] $additionalServices
 * @property-read int|null $additional_services_count
 * @method static \Database\Factories\AdditionalServiceNameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalServiceName whereName($value)
 * @mixin \Eloquent
 */
class AdditionalServiceName extends Model
{
    use HasFactory,
        Filterable;

    public $timestamps = false;

    public function additionalServices(): HasMany
    {
        return $this->hasMany( AdditionalService::class );
    }
}
