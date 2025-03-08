<?php

namespace App\Orchid\Screens\Geo\Metro;

use App\Models\City;
use App\Models\LineMetro;
use App\Models\Metro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MetroEditScreen extends Screen
{
    public ?Metro $metro;

    /**
     * @return array
     */
    public function query( Metro $metro ): iterable
    {
        return [
            'metro' => $metro,
            'place' => [
                'lat' => $metro?->lat ?? 0.0,
                'lng' => $metro?->lon ?? 0.0,
            ]
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->metro->exists
            ? 'Редактирование станции метро'
            : 'Добавить новую станцию метро';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.geo.stations',
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
                ->canSee( $this->metro->exists ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.geo.stations' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows( [
                Select::make( 'metro.city_id' )
                    ->options(
                        City::get()
                            ->map( function( $item ) {
                                return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                            } )
                            ->pluck( 'name', 'id' )
                            ->toArray()
                    )
                    ->empty( '' )
                    ->title( 'Город' )
                    ->required(),

                Select::make( 'metro.line_id' )
                    ->options(
                        LineMetro::get()
                            ->map( function( $item ) {
                                return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                            } )
                            ->pluck( 'name', 'id' )
                            ->toArray()
                    )
                    ->empty( '' )
                    ->title( 'Метро' )
                    ->required(),

                Group::make( [
                    Input::make( 'metro.name.ru' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название станции метро [RU]' )
                        ->required(),

                    Input::make( 'metro.name.en' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название станции метро [EN]' )
                        ->required(),
                ] ),

                Map::make( 'place' )
                    ->title( 'Координаты' ),
            ] )
        ];
    }

    /**
     * @param \App\Models\Metro $metro
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate( Metro $metro, Request $request ) : RedirectResponse
    {
        $input  = $request->collect( 'metro' );
        $insert = $input->only( [
            'city_id',
            'line_id',
            'name',
        ] )->toArray();

        $insert[ 'lat' ] = $request->get( 'place', [] )[ 'lat' ] ?? 0.0;
        $insert[ 'lon' ] = $request->get( 'place', [] )[ 'lng' ] ?? 0.0;

        $metro->fill( $insert );
        $metro->save();

        Toast::info(
            !( $metro->id !== null )
                ? 'Вы успешно добавили новую станцию метро'
                : 'Вы успешно обновили станцию метро'
        )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.geo.stations' );
    }

    public function remove( Metro $model )
    {
        $model->delete();
        Toast::info( __( 'Станция метро удалена' ) );

        return redirect()->route('platform.geo.stations');
    }
}
