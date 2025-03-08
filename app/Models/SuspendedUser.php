<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SuspendedUser
 *
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property string|null $reason
 * @property int $status
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\SuspendedUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuspendedUser whereUserId($value)
 * @mixin \Eloquent
 */
class SuspendedUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
        'user_id'
    ];

    public $dates = [
        'started_at',
        'ended_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }
}
