<?php

namespace App\Filters;

class FileFilter extends QueryFilter
{
    public function albumId( int $id ) : void
    {
        $this->builder->where( 'fileable_type', '=', 'App\Models\Album' )
            ->where( 'fileable_id', '=', $id );
    }

    public function id( int $id ) : void
    {
        $this->builder->where( 'id', '=', $id );
    }
}
