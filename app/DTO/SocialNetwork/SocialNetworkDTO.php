<?php

namespace App\DTO\SocialNetwork;

use App\DTO\BaseDTO;
use App\DTO\IsArray;

/**
 * @property int $id
 * @property int $profile_id
 * @property int $contact_id
 * @property int $sn_id
 * @property string $value
 * @property int $status
 *
 * Class SocialNetworkDTO
 */
class SocialNetworkDTO extends BaseDTO
{
    use IsArray;

    /**
     * @return string
     */
    protected static function array_key(): string
    {
        return 'socialNetworks';
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
            'sn_id'      => [ 'property' => 'sn_id',      'type' => 'int' ],
            'value'      => [ 'property' => 'value',      'type' => 'string' ],
            'status'     => [ 'property' => 'status',     'type' => 'int' ],
        ];
    }
}
