<?php

namespace App\DTO\Contact;

use App\DTO\BaseDTO;
use App\DTO\IsObject;

/**
 * @property int $id
 * @property int $profile_id
 * @property int $country_id
 * @property int $city_id
 * @property int $metro_id
 * @property string $alias
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $site
 * @property string $email
 * @property string $district
 * @property float $lat
 * @property float $lon
 * @property int $filled_percent
 * @property int $additional_filled_percent
 *
 * Class ContactDTO
 */
class ContactDTO extends BaseDTO
{
    use IsObject;

    /**
     * @return string
     */
    protected static function object_key(): string
    {
        return 'contact';
    }

    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'                        => [ 'property' => 'id',                        'type' => 'int' ],
            'profile_id'                => [ 'property' => 'profile_id',                'type' => 'int' ],
            'country_id'                => [ 'property' => 'country_id',                'type' => 'int' ],
            'city_id'                   => [ 'property' => 'city_id',                   'type' => 'int' ],
            'metro_id'                  => [ 'property' => 'metro_id',                  'type' => 'int' ],
            'alias'                     => [ 'property' => 'alias',                     'type' => 'string' ],
            'name'                      => [ 'property' => 'name',                      'type' => 'string' ],
            'description'               => [ 'property' => 'description',               'type' => 'string' ],
            'address'                   => [ 'property' => 'address',                   'type' => 'string' ],
            'phone'                     => [ 'property' => 'phone',                     'type' => 'string' ],
            'site'                      => [ 'property' => 'site',                      'type' => 'string' ],
            'email'                     => [ 'property' => 'email',                     'type' => 'string' ],
            'district'                  => [ 'property' => 'district',                  'type' => 'string' ],
            'lat'                       => [ 'property' => 'lat',                       'type' => 'float' ],
            'lon'                       => [ 'property' => 'lon',                       'type' => 'float' ],
            'filled_percent'            => [ 'property' => 'filled_percent',            'type' => 'int' ],
            'additional_filled_percent' => [ 'property' => 'additional_filled_percent', 'type' => 'int' ],
        ];
    }
}
