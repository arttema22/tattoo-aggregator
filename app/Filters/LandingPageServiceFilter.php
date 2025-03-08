<?php

namespace App\Filters;

class LandingPageServiceFilter extends QueryFilter
{
    public function landingPage( int $landing_page_id ): void
    {
        $this->builder->where( 'landing_page_id', '=', $landing_page_id );
    }
}
