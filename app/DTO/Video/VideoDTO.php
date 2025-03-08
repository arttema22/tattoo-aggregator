<?php

namespace App\DTO\Video;

use App\DTO\BaseDTO;
use App\DTO\IsArray;

/**
 * @property int $id
 * @property int $profile_id
 * @property int $contact_id
 * @property string $url
 * @property string $preview
 * @property string $name
 * @property string $text
 * @property string $html
 * @property array $meta
 *
 * Class VideoDTO
 */
class VideoDTO extends BaseDTO
{
    use IsArray;

    /**
     * @return string
     */
    protected static function array_key(): string
    {
        return 'videos';
    }

    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'         => [ 'property' => 'id',         'type' => 'int' ],
            'profile_id' => [ 'property' => 'profile_id', 'type' => 'int' ],
            'contact_id' => [ 'property' => 'contact_id', 'type' => 'int' ],
            'url'        => [ 'property' => 'url',        'type' => 'string' ],
            'preview'    => [ 'property' => 'preview',    'type' => 'string' ],
            'name'       => [ 'property' => 'name',       'type' => 'string' ],
            'text'       => [ 'property' => 'text',       'type' => 'string' ],
            'html'       => [ 'property' => 'html',       'type' => 'string' ],
            'meta'       => [ 'property' => 'meta',       'type' => 'array' ],
        ];
    }
}
