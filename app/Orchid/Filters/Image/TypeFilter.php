<?php

namespace App\Orchid\Filters\Image;

use App\Enums\SpecializationTypes;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TypeFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Тип';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'type' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereHas( 'album', function ( $query ) {
            $query->where( 'type', '=', $this->request->get( 'type' ) );
        } );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'type' )
                ->options( SpecializationTypes::names() )
                ->empty( '' )
                ->title( 'Тип' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . SpecializationTypes::toName( $this->request->get( 'type' ) );
    }
}
