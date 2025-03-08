<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\PiercingPlaceDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\PiercingPlaceDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPlaceDictionary whereType($value)
 * @mixin \Eloquent
 */
class PiercingPlaceDictionary extends ADictionary
{
    public const TYPE = 3;
}
