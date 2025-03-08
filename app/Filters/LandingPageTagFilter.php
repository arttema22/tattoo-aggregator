<?php

namespace App\Filters;

class LandingPageTagFilter extends QueryFilter
{
    public function excludeLandingPage( int $landing_page_id ): void
    {
        $this->builder->where( 'landing_page_id', '!=', $landing_page_id );
    }

    public function limit( int $count ): void
    {
        $this->builder->limit( $count );
    }
}
