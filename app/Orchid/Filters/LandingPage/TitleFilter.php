<?php

namespace App\Orchid\Filters\LandingPage;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class TitleFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Заголовок';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'title' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where( 'title', 'LIKE' , '%' . $this->request->get( 'title' ) . '%' );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Input::make( 'title' )
        ];
    }

    public function value() : string
    {
        return $this->name() . ': ' . $this->request->get( 'title' );
    }
}
