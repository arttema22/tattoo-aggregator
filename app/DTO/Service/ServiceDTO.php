<?php

namespace App\DTO\Service;

use App\DTO\BaseDTO;
use App\DTO\IsArray;
use App\Models\Service;

/**
 * @property int $id
 * @property int $profile_id
 * @property int $contact_id
 * @property int $type
 * @property string $name
 * @property float $price
 * @property string $currency
 * @property int $status
 * @property int $is_start_price
 *
 * Class ProfileDTO
 */
class ServiceDTO extends BaseDTO
{
    use IsArray;

    /**
     * @return string
     */
    protected static function array_key(): string
    {
        return 'services';
    }

    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'             => [ 'property' => 'id',             'type' => 'int' ],
            'profile_id'     => [ 'property' => 'profile_id',     'type' => 'int' ],
            'contact_id'     => [ 'property' => 'contact_id',     'type' => 'int' ],
            'type'           => [ 'property' => 'type',           'type' => 'int' ],
            'name'           => [ 'property' => 'name',           'type' => 'string' ],
            'price'          => [ 'property' => 'price',          'type' => 'float' ],
            'currency'       => [ 'property' => 'currency',       'type' => 'string' ],
            'status'         => [ 'property' => 'status',         'type' => 'int' ],
            'is_start_price' => [ 'property' => 'is_start_price', 'type' => 'int' ]
        ];
    }

    /**
     * @param Service $service
     * @return ServiceDTO
     */
    public static function fromModel( Service $service ): ServiceDTO
    {
        return parent::fromArray( $service->toArray() );
    }
}
