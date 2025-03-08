<?php

namespace Database\Seeders;

use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingHealingPeriodDictionary;
use App\Models\Dictionaries\PiercingPainLevelDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DictionarySlugSeeder extends Seeder
{
    public function run(): void
    {
        $this->updateDictionarySlug( GenderDictionary::all() );
        $this->updateDictionarySlug( PiercingHealingPeriodDictionary::all() );
        $this->updateDictionarySlug( PiercingPainLevelDictionary::all() );
        $this->updateDictionarySlug( PiercingPlaceDictionary::all() );
        $this->updateDictionarySlug( TattooPlaceDictionary::all() );
        $this->updateDictionarySlug( TattooSizeDictionary::all() );
        $this->updateDictionarySlug( TattooStyleDictionary::all() );
        $this->updateDictionarySlug( TattooTempTypeDictionary::all() );
        $this->updateDictionarySlug( TatuajePlaceDictionary::all() );
    }

    private function updateDictionarySlug( Collection $dictionaries_records )
    {
        $dictionaries_records->each( function ( $dictionary ) {
            if ( !$dictionary->slug ) {
                $dictionary->slug = Str::slug( $dictionary->name );
                $dictionary->save();
            }
        } );
    }
}
