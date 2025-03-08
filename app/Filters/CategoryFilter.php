<?php

namespace App\Filters;

class CategoryFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param string $value
     */
    public function name( string $value ): void
    {
        $this->builder->where( 'name', $value );
    }
}
