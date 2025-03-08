<?php

namespace App\DTO\Feedback;

use App\DTO\BaseDTO;

/**
 * @property int $type
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $message
 *
 * Class FeedbackDTO
 */
class FeedbackDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'      => [ 'property' => 'id',      'type' => 'int' ],
            'name'    => [ 'property' => 'name',    'type' => 'string' ],
            'phone'   => [ 'property' => 'phone',   'type' => 'string' ],
            'email'   => [ 'property' => 'email',   'type' => 'string' ],
            'message' => [ 'property' => 'message', 'type' => 'string' ]
        ];
    }
}