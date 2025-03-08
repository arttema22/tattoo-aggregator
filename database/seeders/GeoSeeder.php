<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\LineMetro;
use App\Models\Metro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() : void
    {
        $raw  = File::get( __DIR__ . '/../data/metro/metro.json' );
        $json = json_decode( $raw, true );

        foreach ( $json as $city_item ) {
            $country = $this->getCountry( $city_item[ 'country' ] );
            [ $lat, $lon ] = explode( ', ', $city_item[ 'center' ] );
            $city = City::factory()
                ->state( [
                    'alias'          => $city_item[ 'alias' ],
                    'name'           => $city_item[ 'name' ],
                    'show_in_filter' => $city_item[ 'show_in_filter' ],
                    'population'     => $city_item[ 'population' ],
                    'lat'            => $lat,
                    'lon'            => $lon,
                ] )
                ->country( $country )
                ->hasMetro( !empty( $city_item[ 'metro' ] ) )
                ->create();

            foreach ( $city_item[ 'metro' ] as $metro ) {
                $line = LineMetro::factory()
                    ->state( [
                        'name'  => $metro[ 'name' ],
                        'color' => $metro[ 'color' ]
                    ] )
                    ->create();

                foreach ( $metro[ 'stations' ] as $item ) {
                    Metro::factory()
                        ->city( $city )
                        ->line( $line )
                        ->state( [
                            'name' => $item[ 'name' ],
                            'lat'  => $item[ 'lat' ],
                            'lon'  => $item[ 'lng' ],
                            'position' => $item[ 'order' ]
                        ] )
                        ->create();
                }
            }
        }
    }

    /**
     * @param array $input
     * @return Country
     */
    protected function getCountry( array $input )
    {
        static $storage = [];

        if ( isset( $storage[ $input[ 'code' ] ] ) ) {
            return $storage[ $input[ 'code' ] ];
        }

        $country = Country::factory()
            ->state( [
                'name' => $input[ 'name' ],
                'iso'  => $input[ 'code' ],
            ] )
            ->create();

        $storage[ $input[ 'code' ] ] = $country;
        return $country;
    }
}
