<?php

namespace App\Filters;

class VideoFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param int $id
     */
    public function profile( int $id ): void
    {
        $this->builder->where( 'profile_id', $id );
    }

    public function ids( array $ids ): void
    {
        $this->builder->whereIn( 'id', $ids );
    }

    public function exceptId( int $id ): void
    {
        $this->builder->where( 'id', '!=', $id );
    }

    public function limit( int $count ): void
    {
        $this->builder->limit( $count );
    }

    public function random( string $seed = '' ): void
    {
        $this->builder->inRandomOrder( $seed );
    }
}
