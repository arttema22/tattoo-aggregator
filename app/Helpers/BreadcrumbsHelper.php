<?php

namespace App\Helpers;

use App\DTO\Breadcrumb\BreadcrumbDTO;
use App\Models\LandingPage;
use Illuminate\Support\Collection;

class BreadcrumbsHelper
{
    public static function getForLandingPage( LandingPage $landing_page ): Collection
    {
        return collect( [
            new BreadcrumbDTO( 'Главная', route( 'index' ) ),
            new BreadcrumbDTO(
                $landing_page->city->name[ 'ru' ],
                route( 'catalog.city', [ 'city' => $landing_page->city->alias ] )
            ),
            new BreadcrumbDTO(
                SpecialisationTypeHelper::getForAlbums()[ $landing_page->type ],
                route( 'search.' . SpecialisationTypeHelper::getTypeFromId( $landing_page->type ) )
            ),
            new BreadcrumbDTO( $landing_page->title, '' ),
        ] );
    }
}