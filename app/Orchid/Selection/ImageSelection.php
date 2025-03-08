<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\Image\AdultFilter;
use App\Orchid\Filters\Image\ApprovedFilter;
use App\Orchid\Filters\Image\CreatedDtFilter;
use App\Orchid\Filters\Image\TypeFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ImageSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TypeFilter::class,
            AdultFilter::class,
            ApprovedFilter::class,
            CreatedDtFilter::class,
        ];
    }
}
