<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\Metro\CountryFilter;
use App\Orchid\Filters\Metro\NameFilter;
use App\Orchid\Filters\Metro\CityFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class MetroSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            NameFilter::class,
            CountryFilter::class,
            CityFilter::class,
        ];
    }
}
