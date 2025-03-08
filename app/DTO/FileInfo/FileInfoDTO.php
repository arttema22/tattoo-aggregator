<?php

namespace App\DTO\FileInfo;

use App\DTO\BaseDTO;

/**
 * @property int $id
 * @property int $file_id
 * @property string $name
 * @property string $description
 * @property array $attribute
 * @property int $is_downloadable
 * @property int $is_adult
 * @property int $is_approved
 *
 * Class ProfileDTO
 */
class FileInfoDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'                => [ 'property' => 'id',              'type' => 'int' ],
            'file_id'           => [ 'property' => 'file_id',         'type' => 'int' ],
            'name'              => [ 'property' => 'name',            'type' => 'string' ],
            'description'       => [ 'property' => 'description',     'type' => 'string' ],
            'attribute'         => [ 'property' => 'attribute',       'type' => 'array' ],  // fixme проверить корректность обработки
            'is_downloadable'   => [ 'property' => 'is_downloadable', 'type' => 'int' ],
            'is_adult'          => [ 'property' => 'is_adult',        'type' => 'int' ],
            'is_approved'       => [ 'property' => 'is_approved',     'type' => 'int' ],
        ];
    }
}
