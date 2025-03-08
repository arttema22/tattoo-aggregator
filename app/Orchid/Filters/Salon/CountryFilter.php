<?php

namespace App\Orchid\Filters\Salon;

use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class CountryFilter extends Filter
{
    /**
     * @return string
     */
    public function name() : string
    {
        return 'Страна';
    }

    /**
     * @return array|null
     */
    public function parameters() : ?array
    {
        return [ 'country' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->where( 'country_id', '=', $this->request->get( 'country' ) );
    }

    /**
     * @return Field[]
     */
    public function display() : iterable
    {
        return [
            Select::make( 'country' )
                ->options(
                    Country::get()
                        ->map( function( $item ) {
                            return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                        } )
                        ->pluck( 'name', 'id' )
                        ->toArray()
                )
                ->empty( '' )
                ->title( 'Страна' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . Country::where( 'id', '=', $this->request->get( 'country' ) )->first()->name[ 'ru' ];
    }
}
