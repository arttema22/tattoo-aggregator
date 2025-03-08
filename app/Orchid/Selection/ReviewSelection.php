<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\Review\IsApprovedFilter;
use App\Orchid\Filters\Review\PublishDateFilter;
use App\Orchid\Filters\Review\SalonFilter;
use App\Orchid\Filters\Review\TypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ReviewSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            SalonFilter::class,
            TypeFilter::class,
            IsApprovedFilter::class,
            PublishDateFilter::class,
        ];
    }
}
