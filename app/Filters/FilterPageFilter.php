<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class FilterPageFilter extends QueryFilter
{
    public function slug( string $slug ) : void
    {
        $this->builder->where( 'slug', '=', $slug );
    }

    public function type( int $type ) : void
    {
        $this->builder->where( 'type', '=', $type );
    }

    public function dictionaries( ...$ids ) : void
    {
        $this->builder->where( function( Builder $query ) use ( $ids ) {
            $query->whereJsonContains( 'dictionary', (int) $ids[0] );

            unset( $ids[0] );
            foreach ( $ids as $id ) {
                $query->orWhereJsonContains( 'dictionary', (int) $id );
            }
        } );
    }
}
