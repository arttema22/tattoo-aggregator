<?php

namespace App\Filters;

trait FilteredById
{
    /**
     * @param int $id
     */
    public function id( int $id ): void
    {
        $this->builder->where( 'id', $id );
    }
}
