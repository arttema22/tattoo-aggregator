<?php

namespace App\Repositories;

use App\Models\FilterPage;

class FilterPageRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return FilterPage::class;
    }
}
