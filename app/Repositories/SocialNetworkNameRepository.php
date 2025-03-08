<?php

namespace App\Repositories;

use App\Models\SocialNetworkName;

class SocialNetworkNameRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return SocialNetworkName::class;
    }
}
