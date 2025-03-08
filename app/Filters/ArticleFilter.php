<?php

namespace App\Filters;

class ArticleFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param string $title
     */
    public function title( string $title ): void
    {
        $this->builder->where( 'title', 'LIKE', "%$title%" );
    }

    /**
     * @param $user_id
     */
    public function userId( $user_id ): void
    {
        $this->builder->where( 'user_id', $user_id );
    }

    public function lastPublished() : void
    {
        $this->builder->orderByDesc( 'published_at' );
    }

    /**
     * @param int $count
     */
    public function limit( int $count ): void
    {
        $this->builder->limit( $count );
    }

    /**
     * @param string $alias
     */
    public function alias( string $alias ): void
    {
        $this->builder->where( 'alias', $alias );
    }

    public function category( string $category_alias ) : void
    {
        $this->builder->whereHas( 'categories', function ( $query ) use ( $category_alias ) {
            $query->where( 'alias', $category_alias );
        } );
    }
}
