<?php

namespace App\Orchid\Filters\Station;

use App\Models\LineMetro;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class MetroFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Ветка метро';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'metro' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->where( 'line_id', '=', $this->request->get( 'metro' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'metro' )
                ->options(
                    LineMetro::get()
                        ->map( function( $item ) {
                            return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                        } )
                        ->pluck( 'name', 'id' )
                        ->toArray()
                )
                ->empty( '' )
                ->title( 'Ветка метро' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . LineMetro::where( 'id', '=', $this->request->get( 'metro' ) )->first()->name[ 'ru' ];
    }
}
