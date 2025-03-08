<?php

namespace Database\Seeders;

use App\Enums\SpecializationTypes;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use App\Models\File;
use App\Models\FileInfo;
use Exception;
use Illuminate\Database\Seeder;
use App\Models\Album;

class FileInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws Exception
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

        $files = File::whereFileableType( Album::class )->get();
        $files->each( function ( File $file ) use ( $dictionary ) {
            $type = $file->fileable->type;
            $attribute = [];

            if ( $type === SpecializationTypes::TATTOO ) {
                $attribute[ 'c' . SpecializationTypes::TATTOO ] = [
                    'd' . GenderDictionary::TYPE =>
                        $dictionary[ 'gender' ]->random( random_int( 0, 1 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooPlaceDictionary::TYPE =>
                        $dictionary[ 'tattoo_place' ]->random( random_int( 0, 1 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooSizeDictionary::TYPE =>
                        $dictionary[ 'tattoo_size' ]->random( random_int( 0, 1 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooStyleDictionary::TYPE =>
                        $dictionary[ 'tattoo_style' ]->random( random_int( 0, 5 ) )->pluck( 'id' )->toArray(),
                    'd' . TattooTempTypeDictionary::TYPE =>
                        $dictionary[ 'tattoo_temp' ]->random( random_int( 0, 1 ) )->pluck( 'id' )->toArray(),
                ];
            }

            if ( $type === SpecializationTypes::TATUAJE ) {
                $attribute[ 'c' . SpecializationTypes::TATUAJE ] = [
                    'd' . TatuajePlaceDictionary::TYPE =>
                        $dictionary[ 'tatuaje_place' ]->random( random_int( 0, 1 ) )->pluck( 'id' )->toArray(),
                ];
            }

            if ( $type === SpecializationTypes::PIERCING ) {
                $attribute[ 'c' . SpecializationTypes::PIERCING ] = [
                    'd' . GenderDictionary::TYPE =>
                        $dictionary[ 'gender' ]->random( random_int( 0, 1 ) )->pluck( 'id' )->toArray(),
                    'd' . PiercingPlaceDictionary::TYPE =>
                        $dictionary[ 'piercing_place' ]->random( random_int( 0, 1 ) )->pluck( 'id' )->toArray(),
                ];
            }

            if ( $type === SpecializationTypes::OTHER ) {
                $attribute[ 'c' . SpecializationTypes::OTHER ] = [];
            }

            FileInfo::factory()
                ->state( [
                    'attribute' => $attribute
                ] )
                ->file( $file )
                ->create();
        } );
    }
}
