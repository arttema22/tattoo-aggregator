<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CityRepository
{
    use HasSearch;

    protected static function model(): string
    {
        return City::class;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCountByContacts() : Collection
    {
        return City::select( [ 'cities.alias', 'cities.name', 'cities.lat', 'cities.lon', DB::raw( 'COUNT(contacts.city_id) as cnt' ) ] )
            ->join( 'contacts', 'contacts.city_id', '=', 'cities.id' )
            ->groupBy( 'contacts.city_id' )
            ->get();
    }
}
