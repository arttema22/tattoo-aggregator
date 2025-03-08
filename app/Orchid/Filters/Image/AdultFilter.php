<?php

namespace App\Orchid\Filters\Image;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class AdultFilter extends Filter
{
    protected array $options = [
        0 => 'нет',
        1 => 'есть',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Взрослый контент';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'adult' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function run( Builder $builder ): Builder
    {
        return $builder->whereHas( 'fileInfo', function ( $query ) {
            $query->where( 'is_adult', '=', $this->request->get( 'adult' ) );
        } );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'adult' )
                ->options( $this->options )
                ->empty( '' )
                ->title( 'Взрослый контент' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . $this->options[ $this->request->get( 'adult' ) ];
    }
}
