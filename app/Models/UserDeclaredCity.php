<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable as OrchidFilterable;
use Orchid\Screen\AsSource;

/**
 * App\Models\UserDeclaredCity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\UserDeclaredCityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDeclaredCity whereUserId($value)
 * @mixin \Eloquent
 */
class UserDeclaredCity extends Model
{
    use HasFactory,
        AsSource,
        OrchidFilterable;

    protected $table = 'user_declared_cities';

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }
}
