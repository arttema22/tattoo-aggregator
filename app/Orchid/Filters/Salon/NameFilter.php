<?php

namespace App\Orchid\Filters\Salon;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class NameFilter extends Filter
{
    /**
     * @return string
     */
    public function name() : string
    {
        return 'Название салона';
    }

    /**
     * @return array|null
     */
    public function parameters() : ?array
    {
        return [ 'name' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->where( 'name', 'like', '%' . $this->request->get( 'name' ) . '%' );
    }

    /**
     * @return Field[]
     */
    public function display() : iterable
    {
        return [
            Input::make( 'name' )
                ->title( 'Название салона' )
                ->help( 'Можно ввести только часть названия' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . $this->request->get( 'name' );
    }
}
