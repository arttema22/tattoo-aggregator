<?php

namespace App\Filters;

class ProfileFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param string $name
     */
    public function name( string $name ): void
    {
        $this->builder->where( 'name', 'LIKE', "%$name%" );
    }

    /**
     * @param string $description
     */
    public function description( string $description ): void
    {
        $this->builder->where( 'description', 'LIKE', "%$description%" );
    }

    /**
     * @param string $type
     */
    public function type( string $type ): void
    {
        $this->builder->where( 'type', $type );
    }

    /**
     * @param $user_id
     */
    public function userId( $user_id ): void
    {
        $this->builder->where( 'user_id', $user_id );
    }
}
