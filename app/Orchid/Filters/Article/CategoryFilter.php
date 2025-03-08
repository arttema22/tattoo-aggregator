<?php

namespace App\Orchid\Filters\Article;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class CategoryFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Категории';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'categories' ];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        $cats = $this->request->get( 'categories' );

        return $builder->whereHas( 'categories', function ( $query ) use ( $cats ) {
            $query->whereIn( 'id', $cats );
        } );
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'categories' )
                ->fromModel( Category::class, 'name', 'id' )
                ->empty( '' )
                ->title( 'Категории' )
                ->multiple()
        ];
    }

    public function value() : string
    {
        return $this->name() . ': ' .
            Category::whereIn( 'id', $this->request->get( 'categories' ) )
                ->pluck( 'name' )
                ->implode( ', ' );
    }
}
