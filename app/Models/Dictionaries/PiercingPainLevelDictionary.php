<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\PiercingPainLevelDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\PiercingPainLevelDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingPainLevelDictionary whereType($value)
 * @mixin \Eloquent
 */
class PiercingPainLevelDictionary extends ADictionary
{
    public const TYPE = 2;
}
