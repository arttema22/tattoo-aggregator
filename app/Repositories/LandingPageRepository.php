<?php

namespace App\Repositories;

use App\Models\LandingPage;

class LandingPageRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return LandingPage::class;
    }
}