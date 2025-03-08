<?php

namespace App\Models\Dictionaries;

/**
 * App\Models\Dictionaries\ServicePiercingDictionary
 *
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string|null $slug
 * @method static \Database\Factories\Dictionaries\ServicePiercingDictionaryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePiercingDictionary whereType($value)
 * @mixin \Eloquent
 */
class ServicePiercingDictionary extends ADictionary
{
    public const TYPE = 12;
}
