<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\SocialNetworkName
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $url
 * @property int $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SocialNetwork[] $socialNetworks
 * @property-read int|null $social_networks_count
 * @method static \Database\Factories\SocialNetworkNameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName filter(\App\Filters\QueryFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialNetworkName whereUrl($value)
 * @mixin \Eloquent
 */
class SocialNetworkName extends Model
{
    use HasFactory, Filterable;

    public $timestamps = false;

    public function socialNetworks(): HasMany
    {
        return $this->hasMany( SocialNetwork::class );
    }
}
