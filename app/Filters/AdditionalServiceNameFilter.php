<?php

namespace App\Filters;

class AdditionalServiceNameFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param array $ids
     */
    public function ids( $ids ) : void
    {
        $this->builder->whereIn( 'id', $ids );
    }
}
