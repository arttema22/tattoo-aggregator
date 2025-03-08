<?php

namespace App\Helpers;

use App\Enums\SpecializationTypes;
use Illuminate\Support\Collection;

class SearchFilterHelper
{
    public static function sortBySelected(Collection $dictionaries, Collection $selected_dictionaries): Collection
    {
        $selected_slugs = $selected_dictionaries->pluck( 'slug' )->all();

        return
            $dictionaries->sort(
                fn ( $b, $a ) => in_array( $a->slug, $selected_slugs, true ) <=> in_array( $b->slug, $selected_slugs, true ) );
    }

    public static function getFiltersByType( int $type, array $dictionary_ids ): array
    {
        if ( $type === SpecializationTypes::TATTOO ) {
            $genders = DictionaryHelper::gender( true );
            $tattoo_places = DictionaryHelper::tattooPlace( true );
            $tattoo_styles = DictionaryHelper::tattooStyle( true );
            $tattoo_sizes = DictionaryHelper::tattooSize( true );
            $tattoo_temp_types = DictionaryHelper::tattooTempType( true );

            $selected_genders = $genders->whereIn( 'id', $dictionary_ids );
            $selected_tattoo_places = $tattoo_places->whereIn( 'id', $dictionary_ids );
            $selected_tattoo_styles = $tattoo_styles->whereIn( 'id', $dictionary_ids );
            $selected_tattoo_sizes = $tattoo_sizes->whereIn( 'id', $dictionary_ids );
            $selected_tattoo_temp_types = $tattoo_temp_types->whereIn( 'id', $dictionary_ids );

            return [
                [
                    'name'     => 'gender',
                    'title'    => 'Пол',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $genders, $selected_genders ),
                    'selected' => $selected_genders->pluck( 'slug' )->all(),
                ],
                [
                    'name'     => 'place',
                    'title'    => 'Место',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $tattoo_places, $selected_tattoo_places ),
                    'selected' => $selected_tattoo_places->pluck( 'slug' )->all(),
                ],
                [
                    'name'     => 'style',
                    'title'    => 'Стиль',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $tattoo_styles, $selected_tattoo_styles ),
                    'selected' => $selected_tattoo_styles->pluck( 'slug' )->all(),
                ],
                [
                    'name'     => 'size',
                    'title'    => 'Размер',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $tattoo_sizes, $selected_tattoo_sizes ),
                    'selected' => $selected_tattoo_sizes->pluck( 'slug' )->all(),
                ],
                [
                    'name'     => 'tempType',
                    'title'    => 'Тип',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $tattoo_temp_types, $selected_tattoo_temp_types ),
                    'selected' => $selected_tattoo_temp_types->pluck( 'slug' )->all(),
                ],
            ];
        }

        if ( $type === SpecializationTypes::TATUAJE ) {
            $tatuaje_places = DictionaryHelper::tatuajePlace( true );
            $selected_tatuaje_places = $tatuaje_places->whereIn( 'id', $dictionary_ids );

            return [
                [
                    'name'     => 'place',
                    'title'    => 'Место',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $tatuaje_places, $selected_tatuaje_places ),
                    'selected' => $selected_tatuaje_places->pluck( 'slug' )->all(),
                ],
            ];
        }

        if ( $type === SpecializationTypes::PIERCING ) {
            $genders = DictionaryHelper::gender( true );
            $piercing_places = DictionaryHelper::piercingPlace( true );

            $selected_genders = $genders->whereIn( 'id', $dictionary_ids );
            $selected_piercing_places = $piercing_places->whereIn( 'id', $dictionary_ids );

            return [
                [
                    'name'     => 'gender',
                    'title'    => 'Пол',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $genders, $selected_genders ),
                    'selected' => $selected_genders->pluck( 'slug' )->all(),
                ],
                [
                    'name'     => 'place',
                    'title'    => 'Место/Тип',
                    'type'     => 'Checkbox',
                    'data'     => self::sortBySelected( $piercing_places, $selected_piercing_places ),
                    'selected' => $selected_piercing_places->pluck( 'slug' )->all(),
                ],
                [
                    'name'     => 'piercingHealingPeriod',
                    'title'    => 'Период заживления, недели',
                    'type'     => 'Range',
                    'data'     => [ 'От', 'До' ],
                    'selected' => [],
                ],
                [
                    'name'     => 'piercingPainLevel',
                    'title'    => 'Уровень боли',
                    'type'     => 'Range',
                    'data'     => [ 'От', 'До' ],
                    'selected' => [],
                ],
            ];
        }

        return [];
    }
}