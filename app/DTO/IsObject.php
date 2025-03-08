<?php

namespace App\DTO;

use App\Http\Requests\BaseFormRequest;

trait IsObject
{
    abstract protected static function map();

    abstract protected static function object_key();

    /**
     * @param BaseFormRequest $request
     * @return static
     */
    public static function fromRequestAsObject( BaseFormRequest $request )
    {
        $data = $request->only( static::object_key() );
        return self::fromArray( $data[ static::object_key() ] ?? [] );
    }
}
