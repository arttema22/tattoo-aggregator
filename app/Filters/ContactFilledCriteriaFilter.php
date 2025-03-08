<?php

namespace App\Filters;

class ContactFilledCriteriaFilter extends QueryFilter
{
    public function type( int $type ): void
    {
        $this->builder->where( 'type', $type );
    }
}