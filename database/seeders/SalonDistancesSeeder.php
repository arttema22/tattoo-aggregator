<?php

namespace Database\Seeders;

use App\Helpers\CoordinatesHelper;
use App\Models\City;
use App\Models\SalonDistance;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class SalonDistancesSeeder extends Seeder
{
    public function run(): void
    {
        $cities = City::with( 'contacts' )->get();
        $cities->each( function ( City $city ) {
            $city_salons = $city->contacts;
            $city_salons->each( function( Contact $salon ) use ( $city_salons ) {
                $insertData = [];
                foreach ( $city_salons as $salon_nearby ) {
                    if ( $salon->id === $salon_nearby->id ) {
                        continue;
                    }

                    $insertData[] = [
                        'salon_id' => $salon->id,
                        'salon_nearby_id' => $salon_nearby->id,
                        'distance' => CoordinatesHelper::vincentyGreatCircleDistance(
                            $salon->lat, $salon->lon, $salon_nearby->lat, $salon_nearby->lon
                        )
                    ];
                }

                SalonDistance::upsert( $insertData, SalonDistance::PRIMARY_COMPOSITE_KEY, [ 'distance' ] );
            } );
        } );
    }
}
