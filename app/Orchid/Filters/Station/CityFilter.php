<?php

namespace App\Orchid\Filters\Station;

use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class CityFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Город';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'city' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->where( 'city_id', '=', $this->request->get( 'city' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'city' )
                ->options(
                    City::where( 'has_metro', '=', 1 )
                        ->get()
                        ->map( function( $item ) {
                            return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                        } )
                        ->pluck( 'name', 'id' )
                        ->toArray()
                )
                ->empty( '' )
                ->title( 'Город' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . City::where( 'id', '=', $this->request->get( 'city' ) )->first()->name[ 'ru' ];
    }
}
