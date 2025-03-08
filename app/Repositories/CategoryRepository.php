<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return Category::class;
    }
}
