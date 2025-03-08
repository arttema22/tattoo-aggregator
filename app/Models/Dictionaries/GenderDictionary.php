<?php

namespace App\Models\Dictionaries;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Dictionaries\GenderDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\GenderDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GenderDictionary whereType($value)
 * @mixin \Eloquent
 */
class GenderDictionary extends ADictionary
{
    public const TYPE = 1;
}
