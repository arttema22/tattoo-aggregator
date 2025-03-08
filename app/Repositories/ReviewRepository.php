<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{
    use HasSearch,
        HasUpdate;

    protected static function model(): string
    {
        return Review::class;
    }

    public function getMaxId(): int
    {
        return (int) Review::max('id');
    }
}
