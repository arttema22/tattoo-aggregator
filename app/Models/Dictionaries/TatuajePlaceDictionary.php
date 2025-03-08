<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\TatuajePlaceDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\TatuajePlaceDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TatuajePlaceDictionary whereType($value)
 * @mixin \Eloquent
 */
class TatuajePlaceDictionary extends ADictionary
{
    public const TYPE = 9;
}
