<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AggSpecialization
 *
 * @property int $contact_id
 * @property int $type
 * @property array $attribute
 * @property-read \App\Models\Contact|null $contact
 * @method static \Database\Factories\AggSpecializationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization query()
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization whereAttribute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AggSpecialization whereType($value)
 * @mixin \Eloquent
 */
class AggSpecialization extends Model
{
    use HasFactory, Filterable;

    public $incrementing = false;

    public $timestamps = false;

    public $casts = [
        'attribute' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function contact() : BelongsTo
    {
        return $this->belongsTo( Contact::class, 'contact_id', 'id' );
    }
}
