<?php

namespace App\Services;

use App\Filters\MetroFilter;
use App\Repositories\MetroRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MetroService
{
    /**
     * @var MetroRepository
     */
    private MetroRepository $metro_repository;

    /**
     * @var string
     */
    private string $locale;

    /**
     * @var MetroFilter
     */
    private MetroFilter $filter;

    public function __construct(
        MetroRepository $metro_repository,
        MetroFilter $filter
    )
    {
        $this->metro_repository = $metro_repository;
        $this->filter = $filter;
        $this->locale = config( 'app.locale' );
    }

    public function getByCity( string $city_alias, string $lang = null ) : array
    {
        $lang = $lang ?: $this->locale;
        $this->filter->setCustomFields( [
            'cityAlias' => $city_alias
        ] );

        $metro = $this->metro_repository->search( $this->filter );
        $output = [];
        foreach ( $metro as $item ) {
            $output[] = [
                'id'   => $item->id,
                'name' => $item->name[ $lang ],
            ];
        }

        return $output;
    }

    /**
     * @param string|null $lang
     * @return Collection
     */
    public function getAllForLang( string $lang = null ) : Collection
    {
        $lang = $lang ?: $this->locale;
        return
            $this->getAll()->map( fn ( $metro ) => [
                'id'      => $metro->id,
                'name'    => $metro->name[ $lang ],
                'city_id' => $metro->city_id
            ] );
    }

    public function getAll() : Collection
    {
        $metro = Cache::get( 'metro' );
        if ( $metro === null ) {
            $metro = $this->metro_repository->search( $this->filter );
            Cache::set( 'metro', $metro );
        }

        return $metro;
    }
}
