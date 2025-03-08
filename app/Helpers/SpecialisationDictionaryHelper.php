<?php

namespace App\Helpers;

use App\Enums\SpecializationTypeNames;
use App\Enums\SpecializationTypes;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;

class SpecialisationDictionaryHelper
{
    /**
     * @param $type
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function get( $type ): array
    {
        $output = [];
        if ( $type & SpecializationTypes::TATTOO ) {
            $output[ SpecializationTypeNames::TATTOO ] = self::getForTattoo();
        }

        if ( $type & SpecializationTypes::TATUAJE ) {
            $output[ SpecializationTypeNames::TATUAJE ] = self::getForTatuaje();
        }

        if ( $type & SpecializationTypes::PIERCING ) {
            $output[ SpecializationTypeNames::PIERCING ] = self::getForPiercing();
        }

        return $output;
    }

    /**
     * @return array[]
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected static function getForTattoo(): array
    {
        return [
            'gender' => [
                'id'    => GenderDictionary::TYPE,
                'title' => 'Пол',
                'data'  => DictionaryHelper::gender( true ),
            ],
            'tattoo_place' => [
                'id'    => TattooPlaceDictionary::TYPE,
                'title' => 'Место',
                'data'  => DictionaryHelper::tattooPlace( true ),
            ],
            'tattoo_size' => [
                'id'    => TattooSizeDictionary::TYPE,
                'title' => 'Размер',
                'data'  => DictionaryHelper::tattooSize( true ),
            ],
            'tattoo_style' => [
                'id'    => TattooStyleDictionary::TYPE,
                'title' => 'Стиль',
                'data'  => DictionaryHelper::tattooStyle( true ),
            ],
            'tattoo_temp_type' => [
                'id'    => TattooTempTypeDictionary::TYPE,
                'title' => 'Тип',
                'data'  => DictionaryHelper::tattooTempType( true ),
            ],
        ];
    }

    /**
     * @return array[]
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected static function getForPiercing(): array
    {
        return [
            'gender' => [
                'id'    => GenderDictionary::TYPE,
                'title' => 'Пол',
                'data'  => DictionaryHelper::gender( true ),
            ],
            'piercing_place' => [
                'id'    => PiercingPlaceDictionary::TYPE,
                'title' => 'Место/Тип',
                'data'  => DictionaryHelper::piercingPlace( true ),
            ],
        ];
    }

    /**
     * @return array[]
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected static function getForTatuaje(): array
    {
        return [
            'tatuaje_place' => [
                'id'    => TatuajePlaceDictionary::TYPE,
                'title' => 'Место',
                'data'  => DictionaryHelper::tatuajePlace( true ),
            ],
        ];
    }

    /**
     * @param int $specialisation_type
     * @param array $attributes
     * @return array
     */
    public static function prepareAttributesForFileInfo( int $specialisation_type, array $attributes ): array
    {
        $specialisation_attributes = [];
        foreach ( $attributes as $key => $value ) {
            if ( $value ) {
                $specialisation_attributes[ 'd' . $key ] = [ (int)$value ];
            }
        }

        return [ 'c' . $specialisation_type => $specialisation_attributes ];
    }
}