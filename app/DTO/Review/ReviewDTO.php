<?php

namespace App\DTO\Review;

use App\DTO\BaseDTO;
use App\DTO\IsArray;

/**
 * @property int $id
 * @property string $name
 * @property string $content
 * @property string $published_at
 * @property int $type
 * @property int $is_approved
 */
class ReviewDTO extends BaseDTO
{
    use IsArray;

    /**
     * @return string
     */
    protected static function array_key(): string
    {
        return 'reviews';
    }

    /**
     * @return array
     */
    protected static function map() : array
    {
        return [
            'id'           => [ 'property' => 'id',           'type' => 'int' ],
            'name'         => [ 'property' => 'name',         'type' => 'string' ],
            'content'      => [ 'property' => 'content',      'type' => 'string' ],
            'published_at' => [ 'property' => 'published_at', 'type' => 'string' ],
            'type'         => [ 'property' => 'type',         'type' => 'int' ],
            'is_approved'  => [ 'property' => 'is_approved',  'type' => 'int' ],
        ];
    }
}
