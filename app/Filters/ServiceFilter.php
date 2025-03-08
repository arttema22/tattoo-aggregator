<?php

namespace App\Filters;

class ServiceFilter extends QueryFilter
{
    /**
     * @param int $id
     */
    public function profile( int $id ): void
    {
        $this->builder->where( 'profile_id', $id );
    }
}
