<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\TattooPlaceDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\TattooPlaceDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooPlaceDictionary whereType($value)
 * @mixin \Eloquent
 */
class TattooPlaceDictionary extends ADictionary
{
    public const TYPE = 4;
}
