<?php

namespace App\DTO;

use App\Http\Requests\BaseFormRequest;
use Generator;

trait IsArray
{
    abstract protected static function map();

    abstract protected static function array_key();

    /**
     * @param BaseFormRequest $request
     * @return Generator
     */
    public static function generatorFromRequest( BaseFormRequest $request ): Generator
    {
        foreach ( $request->only( static::array_key() ) as $array ) {
            foreach ( $array as $tmp ) {
                yield self::fromArray( $tmp );
            }
        }
    }
}
