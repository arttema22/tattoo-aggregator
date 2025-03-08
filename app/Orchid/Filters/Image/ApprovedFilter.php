<?php

namespace App\Orchid\Filters\Image;

use App\Enums\WorkApproved;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ApprovedFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Одобрение';
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
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->whereHas( 'fileInfo', function ( $query ) {
            $query->where( 'is_approved', '=', $this->request->get( 'approved' ) );
        } );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'approved' )
                ->options( WorkApproved::names() )
                ->empty( '' )
                ->title( 'Одобрены' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . WorkApproved::toName( $this->request->get( 'approved' ) );
    }
}
