<?php

namespace App\Orchid\Filters\Review;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class SalonFilter extends Filter
{
    /**
     * @return string
     */
    public function name() : string
    {
        return 'Салон';
    }

    /**
     * @return array|null
     */
    public function parameters() : ?array
    {
        return [ 'salon' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run( Builder $builder ) : Builder
    {
        return $builder->where( 'contact_id', '=', $this->request->get( 'salon' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'salon' )
                ->fromModel( Contact::class, 'name', 'id' )
                ->empty( '' )
                ->title( 'Салон' )
        ];
    }

    /**
     * @return string
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function value() : string
    {
        return $this->name() . ': ' . Contact::where( 'id', '=', $this->request->get( 'salon' ) )->first()->name;
    }
}
