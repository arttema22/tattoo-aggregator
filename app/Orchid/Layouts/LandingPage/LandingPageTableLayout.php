<?php

namespace App\Orchid\Layouts\LandingPage;

use App\Enums\SpecializationTypes;
use App\Models\LandingPage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LandingPageTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'pages';

    /**
     * @return bool
     */
    public function striped() : bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function textNotFound() : string
    {
        return 'Пусто';
    }

    /**
     * @return string
     */
    public function subNotFound() : string
    {
        return 'Нет данных для отображения';
    }

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'type', 'Тип' )
                ->render( function ( $model ) {
                    return SpecializationTypes::toName( $model->type );
                } ),

            TD::make( 'city', 'Город' )
                ->render( function ( $model ) {
                    return $model->city->name[ 'ru' ] ?? '-';
                } ),

            TD::make( 'slug', 'Уникальный путь' )
                ->render( function ( $model ) {
                    return Link::make( $model->slug )
                        ->route( 'landing-page.index', [
                            $model->city->alias,
                            $model->slug,
                        ] )
                        ->class( 'btn btn-link text-decoration-underline' )
                        ->target( '_blank' );
                } ),

            TD::make( 'title', 'Заголовок' )
                ->width( '500px' ),

            TD::make( 'dictionary', 'Фильтры' )
                ->render( function ( $model ) {
                    $output = [];

                    foreach ( $model->dictionary as $id ) {
                        $output[] = '<kbd>' . $this->query->get( 'dictionaries' )[ $id ] . '</kbd>';
                    }

                    return implode( '<br>', $output );
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( LandingPage $model ) {
                    return DropDown::make()
                        ->icon( 'options-vertical' )
                        ->list( [
                            Link::make( __( 'Edit' ) )
                                ->route( 'platform.landing-pages.edit', $model->id )
                                ->icon( 'pencil' ),

                            Button::make( __( 'Delete' ) )
                                ->icon( 'trash' )
                                ->method( 'remove', [
                                    'id' => $model->id,
                                ] ),
                        ] );
                } )
        ];
    }
}
