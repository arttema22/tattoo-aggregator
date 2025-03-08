<?php

namespace App\Filters;

class SalonDistanceFilter extends QueryFilter
{
    public function distance( string $value ): void
    {
        $this->builder->where( 'distance', '<=', $value );
    }

    public function salonId( int $id ): void
    {
        $this->builder->where( 'salon_id', $id );
    }
}