<?php

namespace App\Orchid\Screens\Dictionary;

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
use App\Orchid\Layouts\Dictionary\DictionaryTableLayout;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;

class DictionaryListScreen extends Screen
{
    /**
     * @return array
     */
    public function query(): iterable
    {
        return [
            'dictionaries' => [
                new Repository( [ 'type' => GenderDictionary::TYPE, 'name' => 'Пол' ] ),
                new Repository( [ 'type' => PiercingHealingPeriodDictionary::TYPE, 'name' => 'Пирсинг: время заживления' ] ),
                new Repository( [ 'type' => PiercingPainLevelDictionary::TYPE, 'name' => 'Пирсинг: Уровень боли' ] ),
                new Repository( [ 'type' => PiercingPlaceDictionary::TYPE, 'name' => 'Пирсинг: Место' ] ),
                new Repository( [ 'type' => ServiceOtherDictionary::TYPE, 'name' => 'Другие услуги' ] ),
                new Repository( [ 'type' => ServicePiercingDictionary::TYPE, 'name' => 'Услуги пирсинга' ] ),
                new Repository( [ 'type' => ServiceTattooDictionary::TYPE, 'name' => 'Услуги тату' ] ),
                new Repository( [ 'type' => ServiceTatuajeDictionary::TYPE, 'name' => 'Услуги татуажа' ] ),
                new Repository( [ 'type' => TattooPlaceDictionary::TYPE, 'name' => 'Тату: Место' ] ),
                new Repository( [ 'type' => TattooSizeDictionary::TYPE, 'name' => 'Тату: Место' ] ),
                new Repository( [ 'type' => TattooStyleDictionary::TYPE, 'name' => 'Тату: Стиль' ] ),
                new Repository( [ 'type' => TattooTempTypeDictionary::TYPE, 'name' => 'Тату: Временное' ] ),
                new Repository( [ 'type' => TatuajePlaceDictionary::TYPE, 'name' => 'Татуаж: Место' ] ),
            ]
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Списки словарей';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.dictionaries',
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            DictionaryTableLayout::class
        ];
    }
}
