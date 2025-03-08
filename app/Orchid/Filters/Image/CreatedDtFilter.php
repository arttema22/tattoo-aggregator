<?php

namespace App\Orchid\Filters\Image;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateRange;

class CreatedDtFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Дата добавления';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'dt' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereBetween( 'created_at', $this->request->get( 'dt' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            DateRange::make( 'dt' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': с ' . $this->request->get( 'dt' )[ 'start' ] . ' по ' . $this->request->get( 'dt' )[ 'end' ];
    }
}
