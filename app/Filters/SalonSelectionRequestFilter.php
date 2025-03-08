<?php

namespace App\Filters;

class SalonSelectionRequestFilter extends QueryFilter
{
    public function city( int $city_id ): void
    {
        $this->builder->where( 'city_id', '=', $city_id );
    }

    public function landingPage( int $landing_page_id ): void
    {
        $this->builder->where( 'landing_page_id', '=', $landing_page_id );
    }
}