<?php

namespace App\DTO;

use App\Http\Requests\BaseFormRequest;
use Arr;
use Carbon\Carbon;

abstract class BaseDTO
{
    abstract protected static function map();

    /**
     * @param BaseFormRequest $request
     * @return static
     */
    public static function fromRequest( BaseFormRequest $request )
    {
        $dto = new static();
        foreach ( $request->only( array_keys( static::map() ) ) as $key => $value ) {
            if ( !isset( static::map()[ $key ] ) ) {
                continue;
            }

            $item = static::map()[ $key ];

            $dto_property = $item['property'];

            $dto->$dto_property =
                self::formatValue(
                    $value,
                    $item['type'],
                    $item['type_additional'] ?? null );
        }

        return $dto;
    }

    /**
     * @param $value
     * @param string $type
     * @param string|null $type_additional
     * @return Carbon|false|mixed
     */
    protected static function formatValue( $value, string $type, ?string $type_additional )
    {
        if ( $type === 'Carbon' ) {
            if ( $type_additional !== null ) {
                $carbon = Carbon::createFromFormat( $type_additional, $value );
            } else {
                $carbon = Carbon::parse( $value );
            }

            return $carbon;
        }

        settype( $value, $type );
        return $value;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray( array $data )
    {
        $dto = new static();
        foreach ( Arr::only( $data, array_keys( static::map() ) ) as $key => $value ) {
            if ( !isset( static::map()[ $key ] ) ) {
                continue;
            }

            $item = static::map()[ $key ];

            $dto_property = $item['property'];

            $dto->$dto_property =
                self::formatValue(
                    $value,
                    $item['type'],
                    $item['type_additional'] ?? null );
        }

        return $dto;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $output = [];
        foreach ( static::map() as $tmp ) {
            if ( isset( $tmp[ 'property' ] ) ) {
                $property = $tmp[ 'property' ];
                if ( property_exists( $this, $property ) ) {
                    $output[ $property ] = $this->$property;
                } elseif( isset( $tmp[ 'default' ] ) ) {
                    $output[ $property ] = $tmp[ 'default' ];
                }
            }
        }

        return $output;
    }

    public function __set( string $key, mixed $value ) : void
    {
        if ( !isset( static::map()[ $key ] ) ) {
            return;
        }

        $item = static::map()[ $key ];
        $dto_property = $item['property'];

        $this->$dto_property = self::formatValue(
            $value,
            $item['type'],
            $item['type_additional'] ?? null
        );
    }
}
