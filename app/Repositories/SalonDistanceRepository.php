<?php

namespace App\Repositories;

use App\Models\SalonDistance;
use Illuminate\Support\Collection;

class SalonDistanceRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return SalonDistance::class;
    }

    public function updateOrCreate( Collection $data ): void
    {
        SalonDistance::upsert(
            $data->toArray(),
            SalonDistance::PRIMARY_COMPOSITE_KEY,
            [ 'distance' ] );
    }
}