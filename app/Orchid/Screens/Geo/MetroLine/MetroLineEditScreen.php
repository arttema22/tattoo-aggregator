<?php

namespace App\Orchid\Screens\Geo\MetroLine;

use App\Models\LineMetro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MetroLineEditScreen extends Screen
{
    public ?LineMetro $line_metro;

    /**
     * @return array
     */
    public function query( LineMetro $line_metro ): iterable
    {
        return [
            'line_metro' => $line_metro
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->line_metro->exists
            ? 'Редактирование метро'
            : 'Добавить новое метро';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.geo.metro',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make( 'Сохранить' )
                ->icon( 'pencil' )
                ->method( 'createOrUpdate' ),

            Button::make( 'Удалить' )
                ->icon( 'trash' )
                ->method( 'remove' )
                ->canSee( $this->line_metro->exists ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.geo.metro' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows( [
                Group::make( [
                    Input::make( 'line_metro.name.ru' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название метро [RU]' )
                        ->required(),

                    Input::make( 'line_metro.name.en' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название метро [EN]' )
                        ->required(),
                ] ),

                Input::make( 'line_metro.color' )
                    ->type( 'color' )
                    ->title( 'Цвет' )
                    ->required()
                    ->style( 'max-width: inherit' )
                    ->addBeforeRender( function () {
                        $this->attributes[ 'value' ] = '#' . $this->attributes[ 'value' ];
                    }),
            ] )
        ];
    }

    /**
     * @param LineMetro $line_metro
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate( LineMetro $line_metro, Request $request ) : RedirectResponse
    {
        $input  = $request->collect( 'line_metro' );
        $insert = $input->only( [
            'name',
            'color',
        ] )->toArray();

        $insert[ 'color' ] = str_replace( '#', '', $insert[ 'color' ] );
        $line_metro->fill( $insert );
        $line_metro->save();

        Toast::info(
            !( $line_metro->id !== null )
                ? 'Вы успешно добавили новое метро'
                : 'Вы успешно обновили метро'
        )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.geo.metro' );
    }

    public function remove( LineMetro $model )
    {
        $model->delete();
        Toast::info( __( 'Метро удалено' ) );

        return redirect()->route('platform.geo.metro');
    }
}
