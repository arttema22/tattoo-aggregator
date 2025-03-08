<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\PiercingHealingPeriodDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\PiercingHealingPeriodDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PiercingHealingPeriodDictionary whereType($value)
 * @mixin \Eloquent
 */
class PiercingHealingPeriodDictionary extends ADictionary
{
    public const TYPE = 8;
}
