<?php

namespace App\Orchid\Layouts\Article;

use App\Models\Article;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ArticleListLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'articles';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'title', 'Заголовок' )
                ->cantHide(),

            TD::make( 'categories', 'Категории' )
                ->cantHide()
                ->render( function ( Article $model ) {
                    $output = [];
                    foreach ( $model->categories as $item ) {
                        $output[] = '<kbd>' . $item->name . '</kbd>';
                    }

                    return implode( ' ', $output );
                } ),

            TD::make( 'users', 'Автор' )
                ->render( function ( Article $model ) {
                    return $model->user->name;
                } ),

            TD::make( 'published_at', 'Опубликован' )
                ->defaultHidden()
                ->render( function ( Article $model ) {
                    return $model->published_at !== null
                        ? $model->published_at->format( 'd.m.Y' )
                        : '-';
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( Article $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.articles.edit', $model->id )
                                ->icon( 'pencil' ),

                            Button::make( __( 'Delete' ) )
                                ->icon('trash')
                                ->confirm( __( 'Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.' ) )
                                ->method( 'remove', [
                                    'id' => $model->id,
                                ] ),
                        ] );
                } )
        ];
    }
}
