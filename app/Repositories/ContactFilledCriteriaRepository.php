<?php

namespace App\Repositories;

use App\Models\ContactFilledCriteria;

class ContactFilledCriteriaRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return ContactFilledCriteria::class;
    }
}