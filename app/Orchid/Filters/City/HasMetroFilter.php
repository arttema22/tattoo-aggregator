<?php

namespace App\Orchid\Filters\City;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class HasMetroFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Наличие метро';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'has-metro' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where( 'has_metro', '=', $this->request->get( 'has-metro' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'has-metro' )
                ->options( [
                    0 => 'Нет',
                    1 => 'Есть',
                ] )
                ->empty( '' )
                ->title( 'Наличие метро' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        $val = match ( $this->request->get( 'has-metro' ) ) {
            '0' => 'Нет',
            '1' => 'Есть',
        };

        return $this->name() . ': ' . $val;
    }
}
