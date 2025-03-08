<?php

namespace App\Orchid\Selection;

use App\Orchid\Filters\Article\AuthorFilter;
use App\Orchid\Filters\Article\CategoryFilter;
use App\Orchid\Filters\Article\TitleFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ArticleSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TitleFilter::class,
            AuthorFilter::class,
            CategoryFilter::class,
        ];
    }
}
