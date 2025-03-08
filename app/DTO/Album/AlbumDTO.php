<?php

namespace App\DTO\Album;

use App\DTO\BaseDTO;
use App\DTO\IsArray;

/**
 * @property int $id
 * @property int $contact_id
 * @property int $type
 * @property string $name
 * @property string $description
 *
 * Class AlbumDTO
 */
class AlbumDTO extends BaseDTO
{
    use IsArray;

    /**
     * @return string
     */
    protected static function array_key(): string
    {
        return 'albums';
    }

    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'          => [ 'property' => 'id',          'type' => 'int' ],
            'contact_id'  => [ 'property' => 'contact_id',  'type' => 'int' ],
            'type'        => [ 'property' => 'type',        'type' => 'int' ],
            'name'        => [ 'property' => 'name',        'type' => 'string' ],
            'description' => [ 'property' => 'description', 'type' => 'string' ]
        ];
    }
}
