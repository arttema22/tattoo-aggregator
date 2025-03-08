<?php

namespace App\Orchid\Filters\City;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class NameFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Название города';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'name' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereJsonContains( 'name->ru', $this->request->get( 'name' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Input::make( 'name' )
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
