<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\TattooTempTypeDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\TattooTempTypeDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooTempTypeDictionary whereType($value)
 * @mixin \Eloquent
 */
class TattooTempTypeDictionary extends  ADictionary
{
    public const TYPE = 7;
}
