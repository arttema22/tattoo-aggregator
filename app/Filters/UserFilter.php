<?php

namespace App\Filters;

class UserFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param string $name
     */
    public function name( string $name ): void
    {
        $this->builder->where( 'name', $name );
    }

    /**
     * @param string $email
     */
    public function email( string $email ): void
    {
        $this->builder->where( 'email', $email );
    }
}
