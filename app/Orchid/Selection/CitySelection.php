<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\City\CountryFilter;
use App\Orchid\Filters\City\HasMetroFilter;
use App\Orchid\Filters\City\NameFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class CitySelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            NameFilter::class,
            CountryFilter::class,
            HasMetroFilter::class,
        ];
    }
}
