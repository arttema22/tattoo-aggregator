<?php

namespace App\Helpers;

use App\Enums\SpecializationTypeNames;
use App\Enums\SpecializationTypes;

class SpecialisationTypeHelper
{
    /**
     * @param string $type
     * @return string
     */
    public static function titleFromName( string $type ): string
    {
        return match ( $type ) {
            SpecializationTypeNames::TATTOO   => 'Каталог тату',
            SpecializationTypeNames::TATUAJE  => 'Каталог татуажа',
            SpecializationTypeNames::PIERCING => 'Каталог пирсинга',
            default                           => 'Каталог других работ',
        };
    }

    /**
     * @param string $type
     * @return int
     */
    public static function getTypeFromName( string $type ): int
    {
        return match ( $type ) {
            SpecializationTypeNames::TATTOO   => SpecializationTypes::TATTOO,
            SpecializationTypeNames::TATUAJE  => SpecializationTypes::TATUAJE,
            SpecializationTypeNames::PIERCING => SpecializationTypes::PIERCING,
            default                           => SpecializationTypes::OTHER,
        };
    }

    /**
     * @param int $id
     * @return string
     */
    public static function getTypeFromId( int $id ) : string
    {
        return match ( $id ) {
            SpecializationTypes::TATTOO   => SpecializationTypeNames::TATTOO,
            SpecializationTypes::TATUAJE  => SpecializationTypeNames::TATUAJE,
            SpecializationTypes::PIERCING => SpecializationTypeNames::PIERCING,
            SpecializationTypes::OTHER    => SpecializationTypeNames::OTHER,
        };
    }

    /**
     * @return array
     */
    public static function getForAlbums(): array
    {
        return [
            SpecializationTypes::TATTOO   => 'Татуировки',
            SpecializationTypes::TATUAJE  => 'Перманентный макияж',
            SpecializationTypes::PIERCING => 'Пирсинг',
            SpecializationTypes::OTHER    => 'Другое',
        ];
    }
}
