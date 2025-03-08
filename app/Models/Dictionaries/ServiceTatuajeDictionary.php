<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\ServiceTatuajeDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\ServiceTatuajeDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceTatuajeDictionary whereType($value)
 * @mixin \Eloquent
 */
class ServiceTatuajeDictionary extends ADictionary
{
    public const TYPE = 11;
}
