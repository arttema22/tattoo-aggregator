<?php

namespace App\Filters;

class AlbumFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param int $id
     */
    public function contact( int $id ): void
    {
        $this->builder->where( 'contact_id', $id );
    }

    /**
     * @param int $type
     */
    public function type( int $type ): void
    {
        $this->builder->where( 'type', $type );
    }
}
