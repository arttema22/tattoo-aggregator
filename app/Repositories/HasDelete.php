<?php

namespace App\Repositories;

trait HasDelete
{
    abstract protected static function model();

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return (bool)static::model()::whereId( $id )->delete();
    }
}
