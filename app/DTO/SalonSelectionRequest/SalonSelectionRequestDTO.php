<?php

namespace App\DTO\Review;

use App\DTO\BaseDTO;

/**
 * @property int $id
 * @property array $types
 * @property int $city_id
 * @property string $phone
 * @property string $description
 * @property int $is_mail_sent
 * @property int $landing_page_id
 *
 * Class SalonSelectionRequestDTO
 */
class SalonSelectionRequestDTO extends BaseDTO
{
    protected static function map(): array
    {
        return [
            'id'              => [ 'property' => 'id',             'type' => 'int' ],
            'types'           => [ 'property' => 'types',          'type' => 'array' ],
            'city_id'         => [ 'property' => 'city_id',        'type' => 'int' ],
            'phone'           => [ 'property' => 'phone',          'type' => 'string' ],
            'description'     => [ 'property' => 'description',    'type' => 'string' ],
            'is_mail_sent'    => [ 'property' => 'is_mail_sent',   'type' => 'int' ],
            'landing_page_id' => [ 'property' => 'landing_page_id', 'type' => 'int' ],
        ];
    }
}