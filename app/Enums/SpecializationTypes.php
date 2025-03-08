<?php

namespace App\Enums;

use App\Enums\Base\IEnum;

class SpecializationTypes implements IEnum
{
    public const TATTOO   = 1;

    public const TATUAJE  = 2;

    public const PIERCING = 4;

    public const OTHER    = 8;

    public const ALL      = 15;

    /**
     * @param int $id
     * @return string
     */
    public static function toName( int $id ) : string
    {
        return match ( $id ) {
            self::TATTOO   => 'Татуировки',
            self::PIERCING => 'Пирсинг',
            self::TATUAJE  => 'Татуаж',
            self::OTHER    => 'Другое',
        };
    }

    /**
     * @return string[]
     */
    public static function names() : array
    {
        return [
            self::TATTOO   => 'Татуировки',
            self::PIERCING => 'Пирсинг',
            self::TATUAJE  => 'Татуаж',
            self::OTHER    => 'Другое',
        ];
    }
}
