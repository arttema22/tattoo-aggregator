<?php

namespace App\Helpers;

use App\Enums\ProfileTypes;

class ProfileHelper
{
    /**
     * @param int $type
     * @return string
     */
    public static function titleProfileType( int $type ): string
    {
        return match ( $type ) {
            ProfileTypes::MASTER   => 'Мастер',
            ProfileTypes::SALON    => 'Салон',
            default                => '',
        };
    }
}