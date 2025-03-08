<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\ServiceTattooDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\ServiceTattooDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTattooDictionary whereType($value)
 * @mixin \Eloquent
 */
class ServiceTattooDictionary extends ADictionary
{
    public const TYPE = 10;
}
