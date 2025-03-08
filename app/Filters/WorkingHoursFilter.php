<?php

namespace App\Filters;

class WorkingHoursFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param int $id
     */
    public function profile( int $id ): void
    {
        $this->builder->orWhere( 'profile_id', $id );
    }

    /**
     * @param int $id
     */
    public function contact( int $id ): void
    {
        $this->builder->orWhere( 'contact_id', $id );
    }
}
