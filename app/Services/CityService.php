<?php

namespace App\Services;

use App\Filters\CityFilter;
use App\Models\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Repositories\CityRepository;

class CityService
{
    /**
     * @var CityRepository
     */
    private CityRepository $city_repository;

    /**
     * @var string
     */
    private string $locale;

    /**
     * @var \App\Filters\CityFilter
     */
    private CityFilter $city_filter;

    public function __construct(
        CityRepository $city_repository,
        CityFilter $city_filter
    )
    {
        $this->city_repository = $city_repository;
        $this->city_filter = $city_filter;
        $this->locale = config( 'app.locale' );
    }

    public function getNameByAlias( string $alias ) : ?City
    {
        $cities = $this->getAll();
        return $cities->where( 'alias', $alias )->first();
    }

    public function getByCountry( int $country_id, string $lang = null ) : Collection
    {
        $lang   = $lang ?: $this->locale;
        $cities = $this->getAll();

        $output = new Collection();
        foreach ( $cities as $city ) {
            if ( $city->country_id === $country_id ) {
                $output->add( [
                    'id'        => $city->id,
                    'name'      => $city->name[ $lang ],
                    'alias'     => $city->alias,
                    'has_metro' => $city->has_metro,
                    'lat'       => $city->lat,
                    'lon'       => $city->lon,
                ] );
            }
        }

        return $output;
    }

    public function getAll() : Collection
    {
        $cities = Cache::get( 'cities' );
        if ( $cities === null ) {
            $cities = $this->city_repository->search( $this->city_filter );
            Cache::set( 'cities', $cities );
        }

        return $cities;
    }

    /**
     * @param string $name
     * @param string|null $lang
     * @return int|null
     */
    public function getIdByName( string $name, string $lang = null ): ?int
    {
        $lang   = $lang ?: $this->locale;
        $cities = $this->getAll();

        $city = $cities->where( 'name.' . $lang, $name )->first();
        return $city['id'] ?? null;
    }

    /**
     * @return Collection
     */
    public function getCountContacts() : Collection
    {
        return $this->city_repository->getCountByContacts();
    }
}
