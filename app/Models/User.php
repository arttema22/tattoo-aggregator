<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Platform\Models\User as Authenticatable;
use App\Models\Traits\Filterable as CustomFilterable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int $role
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Profile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orchid\Platform\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuspendedUser[] $suspendedUsers
 * @property-read int|null $suspended_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserDeclaredCity[] $userDeclaredCities
 * @property-read int|null $user_declared_cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|User averageByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAccess(string $permitWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User byAnyAccess($permitsWithoutWildcard)
 * @method static \Illuminate\Database\Eloquent\Builder|User countByDays($startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User countForGroup(string $groupColumn)
 * @method static \Illuminate\Database\Eloquent\Builder|User defaultSort(string $column, string $direction = 'asc')
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|User filters(?\Orchid\Filters\HttpFilter $httpFilter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApply(iterable $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User filtersApplySelection($selection)
 * @method static \Illuminate\Database\Eloquent\Builder|User maxByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User minByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User sumByDays(string $value, $startDate = null, $stopDate = null, ?string $dateColumn = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User valuesByDays(string $value, $startDate = null, $stopDate = null, string $dateColumn = 'created_at')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens,
        CustomFilterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'role',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne( Profile::class );
    }

    public function articles(): HasMany
    {
        return $this->hasMany( Article::class );
    }

    public function suspendedUsers(): HasMany
    {
        return $this->hasMany( SuspendedUser::class );
    }

    public function userDeclaredCities(): HasMany
    {
        return $this->hasMany( UserDeclaredCity::class );
    }

    /**
     * Переопределение функции, отправляющей сообщение о смене пароля
     * @param string $token
     */
    public function sendPasswordResetNotification( $token ): void
    {
        $this->notify( new ResetPasswordNotification($token) );
    }

    /**
     * Переопределение функции, отправляющей сообщение о подтверждении электронной почты
     * @return void
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify( new VerifyEmailNotification() );
    }
}
