<?php

namespace App\DTO\AdditionalService;

use App\DTO\BaseDTO;
use App\DTO\IsArray;

/**
 * @property int $id
 * @property int $profile_id
 * @property int $contact_id
 * @property int $as_id
 *
 * Class AdditionalServiceDTO
 */
class AdditionalServiceDTO extends BaseDTO
{
    use IsArray;

    /**
     * @return string
     */
    protected static function array_key(): string
    {
        return 'additionalServices';
    }

    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'         => [ 'property' => 'id',         'type' => 'int' ],
            'as_id'      => [ 'property' => 'as_id',      'type' => 'int' ],
            'profile_id' => [ 'property' => 'profile_id', 'type' => 'int' ],
            'contact_id' => [ 'property' => 'contact_id', 'type' => 'int' ],
        ];
    }
}
