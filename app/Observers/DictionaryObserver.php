<?php

namespace App\Observers;

use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingHealingPeriodDictionary;
use App\Models\Dictionaries\PiercingPainLevelDictionary;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class DictionaryObserver
{
    public function created( Model $model ) : void
    {
        $this->clear();
    }

    public function updated( Model $model ) : void
    {
        $this->clear();
    }

    public function deleted( Model $model ) : void
    {
        $this->clear();
    }

    public function restored( Model $model ) : void
    {
        $this->clear();
    }

    protected function clear() : void
    {
        $dictionaries = [
            GenderDictionary::class,
            PiercingHealingPeriodDictionary::class,
            PiercingPainLevelDictionary::class,
            PiercingPlaceDictionary::class,
            TattooPlaceDictionary::class,
            TattooSizeDictionary::class,
            TattooStyleDictionary::class,
            TattooTempTypeDictionary::class,
            TatuajePlaceDictionary::class,
            ServiceTattooDictionary::class,
            ServiceTatuajeDictionary::class,
            ServicePiercingDictionary::class,
            ServiceOtherDictionary::class,
        ];

        foreach ( $dictionaries as $item ) {
            Cache::forget( $item );
            Cache::forget( $item . '-slug' );
        }
    }
}
