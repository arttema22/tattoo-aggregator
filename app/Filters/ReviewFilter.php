<?php

namespace App\Filters;

use App\Enums\ReviewApprove;

class ReviewFilter extends QueryFilter
{
    /**
     * @param array $ids
     */
    public function ids( array $ids ) : void
    {
        $this->builder->whereIn( 'id', $ids );
    }

    /**
     * @return void
     */
    public function isApproved() : void
    {
        $this->builder->where( 'is_approved', '=', ReviewApprove::YES );
    }

    /**
     * @param int $contact_id
     * @return void
     */
    public function contact( int $contact_id ) : void
    {
        $this->builder->where( 'contact_id', '=', $contact_id );
    }

    /**
     * @param string $direction
     * @return void
     */
    public function sortByPublish( string $direction = 'desc' ) : void
    {
        $this->builder->orderBy( 'published_at', $direction );
    }

    /**
     * @param int $count
     */
    public function limit( int $count ): void
    {
        $this->builder->limit( $count );
    }
}
