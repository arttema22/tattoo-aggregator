<?php

namespace App\Repositories;

use App\Models\LandingPageService;

class LandingPageServiceRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return LandingPageService::class;
    }
}
