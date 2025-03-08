<?php

namespace App\DTO\User;

use App\DTO\BaseDTO;

/**
 * @property int $id
 * @property int $role
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $email_verified_at
 *
 * Class UserDTO
 */
class UserDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'id'                => [ 'property' => 'id',                'type' => 'int' ],
            'role'              => [ 'property' => 'role',              'type' => 'int' ],
            'name'              => [ 'property' => 'name',              'type' => 'string' ],
            'email'             => [ 'property' => 'email',             'type' => 'string' ],
            'password'          => [ 'property' => 'password',          'type' => 'string' ],
            'email_verified_at' => [ 'property' => 'email_verified_at', 'type' => 'Carbon', 'type_additional' => 'Y-m-d H:i:s' ]
        ];
    }
}
