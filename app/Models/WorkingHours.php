<?php

namespace App\Models;

use App\Filters\WorkingHoursFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\WorkingHours
 *
 * @property int $id
 * @property int $profile_id
 * @property int|null $contact_id
 * @property int $day
 * @property string|null $start
 * @property string|null $end
 * @property int $is_weekend
 * @property int $is_nonstop
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contact|null $contact
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\WorkingHoursFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereIsNonstop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereIsWeekend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkingHours whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkingHours extends Model
{
    use HasFactory,
        Filterable,
        AsSource,
        OrchidFilterable;

    protected $table = 'working_hours';

    protected $fillable = [
        'contact_id',
        'day',
        'start',
        'end',
        'is_weekend',
        'is_nonstop'
    ];

    protected $hidden = [
        'profile_id',
        'contact_id'
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo( Contact::class );
    }
}
