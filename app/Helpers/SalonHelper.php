<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class SalonHelper
{
    public static function getNearbyDistanceByCityPopulation( int $population ): int
    {
        foreach ( config( 'salon.nearby.config' ) as $nearby_config ) {
            if ( $nearby_config['min_population'] <= $population ) {
                return $nearby_config['distance'];
            }
        }

        return config( 'salon.nearby.default_distance' );
    }

    public static function getRandomNearbySalons( Collection $salons_distances )
    {
        $count = $salons_distances->count();
        if ( $count > config( 'salon.nearby.count' ) ) {
            return $salons_distances->random( config( 'salon.nearby.count' ) );
        }

        return $salons_distances;
    }
}