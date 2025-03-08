<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\Station\CityFilter;
use App\Orchid\Filters\Station\MetroFilter;
use App\Orchid\Filters\Station\NameFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class StationSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            NameFilter::class,
            MetroFilter::class,
            CityFilter::class,
        ];
    }
}
