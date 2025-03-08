<?php

namespace Database\Seeders;

use App\Enums\SpecializationTypes;
use App\Models\AggSpecialization;
use App\Models\Contact;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use Illuminate\Database\Seeder;

class AggSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        $dictionary = [
            'gender'         => GenderDictionary::all( 'id' ),
            'tattoo_place'   => TattooPlaceDictionary::all( 'id' ),
            'tattoo_size'    => TattooSizeDictionary::all( 'id' ),
            'tattoo_style'   => TattooStyleDictionary::all( 'id' ),
            'tattoo_temp'    => TattooTempTypeDictionary::all( 'id' ),
            'tatuaje_place'  => TatuajePlaceDictionary::all( 'id' ),
            'piercing_place' => PiercingPlaceDictionary::all( 'id' ),
        ];

        Contact::all()->each( function( Contact $contact ) use ( $dictionary ) {
            $type = random_int( 1, 15 );
            $attribute = [];

            if ( $type & SpecializationTypes::TATTOO ) {
                $attribute[ 'c' . SpecializationTypes::TATTOO ] = [
                    'd' . GenderDictionary::TYPE =>
                        $dictionary[ 'gender' ]->random( random_int( 0, $dictionary[ 'gender' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooPlaceDictionary::TYPE =>
                        $dictionary[ 'tattoo_place' ]->random( random_int( 0, $dictionary[ 'tattoo_place' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooSizeDictionary::TYPE =>
                        $dictionary[ 'tattoo_size' ]->random( random_int( 0, $dictionary[ 'tattoo_size' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooStyleDictionary::TYPE =>
                        $dictionary[ 'tattoo_style' ]->random( random_int( 0, $dictionary[ 'tattoo_style' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooTempTypeDictionary::TYPE =>
                        $dictionary[ 'tattoo_temp' ]->random( random_int( 0, $dictionary[ 'tattoo_temp' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                ];
            }

            if ( $type & SpecializationTypes::TATUAJE ) {
                $attribute[ 'c' . SpecializationTypes::TATUAJE ] = [
                    'd' . TatuajePlaceDictionary::TYPE =>
                        $dictionary[ 'tatuaje_place' ]->random( random_int( 0, $dictionary[ 'tatuaje_place' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                ];
            }

            if ( $type & SpecializationTypes::PIERCING ) {
                $attribute[ 'c' . SpecializationTypes::PIERCING ] = [
                    'd' . GenderDictionary::TYPE =>
                        $dictionary[ 'gender' ]->random( random_int( 0, $dictionary[ 'gender' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                    'd' . PiercingPlaceDictionary::TYPE =>
                        $dictionary[ 'piercing_place' ]->random( random_int( 0, $dictionary[ 'piercing_place' ]->count() - 1 ) )->pluck( 'id' )->toArray(),
                ];
            }

            if ( $type & SpecializationTypes::OTHER ) {
                $attribute[ 'c' . SpecializationTypes::OTHER ] = [];
            }

            AggSpecialization::factory()
                ->state( [
                    'type' => $type,
                    'attribute' => $attribute
                ] )
                ->contact( $contact )
                ->create();
        } );
    }
}
