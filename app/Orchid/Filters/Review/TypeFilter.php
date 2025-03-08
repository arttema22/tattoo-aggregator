<?php

namespace App\Orchid\Filters\Review;

use App\Enums\ReviewType;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TypeFilter extends Filter
{
    protected array $options = [
        ReviewType::AUTO  => 'Авто',
        ReviewType::HUMAN => 'Человек',
    ];

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
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->where( 'type', '=', $this->request->get( 'type' ) );
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
