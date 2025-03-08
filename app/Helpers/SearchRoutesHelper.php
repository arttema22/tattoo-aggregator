<?php

namespace App\Helpers;

use App\Enums\SpecializationTypeNames;
use Illuminate\Support\Collection;

class SearchRoutesHelper
{
    public static function getRouteForWorkTag(
        string $specialization_type,
        Collection $dictionariesDTO,
        ?string $attribute ): string
    {
        if ( $specialization_type === SpecializationTypeNames::TATTOO ) {
            return route( 'search.tattoo', $dictionariesDTO[$attribute]?->slug ?? '' );
        }

        if ( $specialization_type === SpecializationTypeNames::PIERCING ) {
            return route( 'search.piercing', $dictionariesDTO[$attribute]?->slug ?? '' );
        }

        if ( $specialization_type === SpecializationTypeNames::TATUAJE ) {
            return route( 'search.tatuaje', $dictionariesDTO[$attribute]?->slug ?? '' );
        }

        return '';
    }

    public static function getRouteForSlug( string $specialization_type, string $slug ): string
    {
        if ( $specialization_type === SpecializationTypeNames::TATTOO ) {
            return route( 'search.tattoo', $slug );
        }

        if ( $specialization_type === SpecializationTypeNames::PIERCING ) {
            return route( 'search.piercing', $slug );
        }

        if ( $specialization_type === SpecializationTypeNames::TATUAJE ) {
            return route( 'search.tatuaje', $slug );
        }

        return '';
    }
}