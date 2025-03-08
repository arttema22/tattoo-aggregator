<?php

namespace App\Orchid\Filters\Salon;

use App\Enums\ProfileTypes;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TypeFilter extends Filter
{
    protected array $options = [
        ProfileTypes::MASTER => 'Мастер',
        ProfileTypes::SALON  => 'Салон',
    ];

    /**
     * @return string
     */
    public function name() : string
    {
        return 'Тип';
    }

    /**
     * @return array|null
     */
    public function parameters() : ?array
    {
        return [ 'type' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->whereHas( 'profile', function ( $query ) {
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
                ->options( $this->options )
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
        return $this->name() . ': ' . $this->options[ $this->request->get( 'type' ) ];
    }
}
