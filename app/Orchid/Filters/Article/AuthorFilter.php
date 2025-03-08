<?php

namespace App\Orchid\Filters\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class AuthorFilter extends Filter
{
    /**
     * @return string
     */
    public function name(): string
    {
        return 'Автор';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'authors' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function run(Builder $builder): Builder
    {
        return $builder->whereIn( 'user_id', $this->request->get( 'authors' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'authors' )
                ->options(
                    Article::with( 'user' )
                        ->groupBy( 'user_id' )
                        ->get()
                        ->map( function( $item ) {
                            return [ 'id' => $item->user->id, 'name' => $item->user->name ];
                        } )
                        ->pluck( 'name', 'id' )
                        ->toArray()
                )
                ->empty( '' )
                ->title( 'Авторы' )
                ->multiple()
        ];
    }

    public function value() : string
    {
        return $this->name() . ': ' .
            User::whereIn( 'id', $this->request->get( 'authors' ) )
                ->pluck( 'name' )
                ->implode( ', ' );
    }
}
