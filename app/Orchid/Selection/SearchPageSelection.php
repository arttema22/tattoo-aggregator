<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\SearchPage\TitleFilter;
use App\Orchid\Filters\SearchPage\TypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class SearchPageSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TypeFilter::class,
            TitleFilter::class,
        ];
    }
}
