<?php

namespace App\Orchid\Filters\Review;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateRange;

class PublishDateFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Опубликованы';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'published' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->whereBetween( 'published_at', array_values( $this->request->get( 'published' ) ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            DateRange::make( 'published' )
                ->vertical()
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . $this->request->get( 'published' )[ 'start' ] . ' - ' . $this->request->get( 'published' )[ 'end' ];
    }
}
