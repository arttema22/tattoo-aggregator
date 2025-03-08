<?php

namespace Database\Seeders;

use App\Enums\SpecializationTypes;
use App\Models\City;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use App\Models\LandingPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LandingPagesSeeder extends Seeder
{
    public function run(): void
    {
        $dictionaries = [
            'gender'         => GenderDictionary::all( 'id' ),
            'tattoo_place'   => TattooPlaceDictionary::all( 'id' ),
            'tattoo_size'    => TattooSizeDictionary::all( 'id' ),
            'tattoo_style'   => TattooStyleDictionary::all( 'id' ),
            'tattoo_temp'    => TattooTempTypeDictionary::all( 'id' ),
            'tatuaje_place'  => TatuajePlaceDictionary::all( 'id' ),
            'piercing_place' => PiercingPlaceDictionary::all( 'id' ),
        ];

        $cities = City::where( 'country_id', 1 )->get()->random( 10 );
        $cities->each( function ( $city ) use ( $dictionaries ) {
            $landing_page_dictionary = [];
            $type = Arr::random( [
                SpecializationTypes::TATTOO,
                SpecializationTypes::TATUAJE,
                SpecializationTypes::PIERCING,
            ] );

            if ( $type === SpecializationTypes::TATTOO ) {
                $random_dictionary = Arr::random( [
                    'gender',
                    'tattoo_place',
                    'tattoo_size',
                    'tattoo_style',
                    'tattoo_temp',
                ] );

                $landing_page_dictionary = $dictionaries[ $random_dictionary ]->pluck( 'id' )->random( 1 );
            }

            if ( $type & SpecializationTypes::TATUAJE ) {
                $landing_page_dictionary = $dictionaries[ 'tatuaje_place' ]->pluck( 'id' )->random( 1 );
            }

            if ( $type === SpecializationTypes::PIERCING ) {
                $random_dictionary = Arr::random( [
                    'gender',
                    'piercing_place',
                ] );

                $landing_page_dictionary = $dictionaries[ $random_dictionary ]->pluck( 'id' )->random( 1 );
            }

            LandingPage::factory()
                ->state([
                    'type' => $type,
                    'dictionary' => $landing_page_dictionary
                ])
                ->city( $city )
                ->create();
        } );
    }
}
