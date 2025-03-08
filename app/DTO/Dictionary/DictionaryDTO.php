<?php

namespace App\DTO\Dictionary;

use App\DTO\BaseDTO;

/**
 * @property int $id
 * @property int $type
 * @property string $name
 * @property string $slug
 *
 * Class DictionaryDTO
 */
class DictionaryDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'   => [ 'property' => 'id',   'type' => 'int' ],
            'type' => [ 'property' => 'type', 'type' => 'int' ],
            'name' => [ 'property' => 'name', 'type' => 'string' ],
            'slug' => [ 'property' => 'slug', 'type' => 'string' ]
        ];
    }
}