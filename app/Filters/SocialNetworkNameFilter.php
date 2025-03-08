<?php

namespace App\Filters;

class SocialNetworkNameFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param array $ids
     */
    public function ids( $ids ) : void
    {
        $this->builder->whereIn( 'id', $ids );
    }

    /**
     * @param int $status
     */
    public function status( int $status ) : void
    {
        $this->builder->where( 'status', $status );
    }
}
