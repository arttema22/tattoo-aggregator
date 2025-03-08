<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\TattooSizeDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\TattooSizeDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TattooSizeDictionary whereType($value)
 * @mixin \Eloquent
 */
class TattooSizeDictionary extends ADictionary
{
    public const TYPE = 5;
}
