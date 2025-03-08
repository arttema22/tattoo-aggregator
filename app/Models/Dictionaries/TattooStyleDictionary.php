<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\TattooStyleDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\TattooStyleDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooStyleDictionary whereType($value)
 * @mixin \Eloquent
 */
class TattooStyleDictionary extends ADictionary
{
    public const TYPE = 6;
}
