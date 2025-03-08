<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\LandingPage\CityFilter;
use App\Orchid\Filters\LandingPage\TitleFilter;
use App\Orchid\Filters\LandingPage\TypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class LandingPageSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TypeFilter::class,
            TitleFilter::class,
            CityFilter::class,
        ];
    }
}
