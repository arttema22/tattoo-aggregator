<?php

namespace App\Models;

use App\Filters\AdditionalServiceFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AdditionalService
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property int $as_id
 * @property-read \App\Models\AdditionalServiceName|null $additionalServiceName
 * @property-read \App\Models\Profile|null $profile
 * @method static \Database\Factories\AdditionalServiceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereAsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdditionalService whereProfileId($value)
 * @mixin \Eloquent
 */
class AdditionalService extends Model
{
    use HasFactory, Filterable;

    public $timestamps = false;

    protected $fillable = [
        'as_id'
    ];

    public function additionalServiceName(): BelongsTo
    {
        return $this->belongsTo( AdditionalServiceName::class, 'as_id' );
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo( Profile::class );
    }
}
