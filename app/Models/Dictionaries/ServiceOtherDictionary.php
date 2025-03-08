<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\ServiceOtherDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\ServiceOtherDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceOtherDictionary whereType($value)
 * @mixin \Eloquent
 */
class ServiceOtherDictionary extends ADictionary
{
    public const TYPE = 13;
}
