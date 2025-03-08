<?php

namespace App\Filters;

class SocialNetworkFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param string $value
     */
    public function value( string $value ): void
    {
        $this->builder->where( 'value', 'LIKE', "%$value%" );
    }

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
