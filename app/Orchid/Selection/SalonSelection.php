<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\Salon\CityFilter;
use App\Orchid\Filters\Salon\CountryFilter;
use App\Orchid\Filters\Salon\NameFilter;
use App\Orchid\Filters\Salon\TypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class SalonSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            NameFilter::class,
            TypeFilter::class,
            CountryFilter::class,
            CityFilter::class,
        ];
    }
}
