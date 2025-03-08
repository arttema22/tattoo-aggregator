<?php

namespace Database\Seeders;

use App\Models\Dictionaries\ADictionary;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\ServiceOtherDictionary;
use App\Models\Dictionaries\ServicePiercingDictionary;
use App\Models\Dictionaries\ServiceTattooDictionary;
use App\Models\Dictionaries\ServiceTatuajeDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() : void
    {
        $data = [
            GenderDictionary::class         => 'gender.txt',
            TattooPlaceDictionary::class    => 'tattoo_place.txt',
            TattooSizeDictionary::class     => 'tattoo_size.txt',
            TattooStyleDictionary::class    => 'tattoo_style.txt',
            TattooTempTypeDictionary::class => 'tattoo_temp_type.txt',
            PiercingPlaceDictionary::class  => 'piercing_place.txt',
            TatuajePlaceDictionary::class   => 'tatuaje_place.txt',

            // услуги
            ServiceTattooDictionary::class  => 'services_tattoo.txt',
            ServiceTatuajeDictionary::class => 'services_tatuaje.txt',
            ServicePiercingDictionary::class=> 'services_piercing.txt',
            ServiceOtherDictionary::class   => 'services_other.txt',
        ];

        foreach ( $data as $dictionary => $file_name ) {
            $this->execute( $dictionary, $file_name );
        }
    }

    /**
     * @param string $dictionary
     * @param string $file_name
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function execute( string $dictionary, string $file_name ) : void
    {
        File::lines( __DIR__ . '/../data/dictionaries/' . $file_name )->each( function ( $item ) use ( $dictionary ) {
            if ( $item === '' ) {
                return;
            }

            /** @var ADictionary $dictionary */
            $dictionary::factory()
                ->state( [
                    'name' => $item
                ] )
                ->create();
        } );
    }
}
