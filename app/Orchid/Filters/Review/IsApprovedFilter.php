<?php

namespace App\Orchid\Filters\Review;

use App\Enums\ReviewApprove;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class IsApprovedFilter extends Filter
{
    protected array $options = [
        ReviewApprove::NO  => 'нет',
        ReviewApprove::YES => 'да',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Проверен';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'approved' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->where( 'is_approved', '=', $this->request->get( 'approved' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'approved' )
                ->options( $this->options )
                ->empty( '' )
                ->title( 'Проверен' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . $this->options[ $this->request->get( 'approved' ) ];
    }
}
