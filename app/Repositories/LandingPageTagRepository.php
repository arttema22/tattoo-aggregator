<?php

namespace App\Repositories;

use App\Models\LandingPageTag;

class LandingPageTagRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return LandingPageTag::class;
    }
}