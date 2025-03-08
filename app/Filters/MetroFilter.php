<?php

namespace App\Filters;

class MetroFilter extends QueryFilter
{
    /**
     * @param string $city_alias
     */
    public function cityAlias( string $city_alias ) : void
    {
        $this->builder->whereHas( 'city', function ( $query ) use ( $city_alias ) {
            $query->where( 'alias', $city_alias );
        } );

    }
}
