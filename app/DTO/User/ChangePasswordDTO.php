<?php

namespace App\DTO\User;

use App\DTO\BaseDTO;

/**
 * @property string $current_password
 * @property string $password
 *
 * Class UserDTO
 */
class ChangePasswordDTO extends BaseDTO
{
    /**
     * @return array
     */
    protected static function map(): array
    {
        return [
            'current_password' => [ 'property' => 'current_password', 'type' => 'string' ],
            'password'         => [ 'property' => 'password',         'type' => 'string' ]
        ];
    }
}