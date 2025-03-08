<?php

namespace App\Enums;

use App\Enums\Base\IEnum;

class SpecializationTypeNames implements IEnum
{
    public const TATTOO   = 'tattoo';

    public const TATUAJE  = 'tatuaje';

    public const PIERCING = 'piercing';

    public const OTHER    = 'other';

    public static function cases() : array
    {
        return [
            self::TATTOO,
            self::PIERCING,
            self::TATUAJE,
            self::OTHER,
        ];
    }

    public static function labels() : array
    {
        return [
            self::TATTOO   => 'Татуировки',
            self::PIERCING => 'Пирсинг',
            self::TATUAJE  => 'Татуаж',
            self::OTHER    => 'Другое',
        ];
    }

    public static function toId( string $name ) : int
    {
        return match ( $name ) {
            self::TATTOO   => SpecializationTypes::TATTOO,
            self::PIERCING => SpecializationTypes::PIERCING,
            self::TATUAJE  => SpecializationTypes::TATUAJE,
            self::OTHER    => SpecializationTypes::OTHER,
            default        => 0,
        };
    }
}
