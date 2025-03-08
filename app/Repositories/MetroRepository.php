<?php

namespace App\Repositories;

use App\Models\Metro;

class MetroRepository
{
    use HasSearch;

    protected static function model()
    {
        return Metro::class;
    }
}
