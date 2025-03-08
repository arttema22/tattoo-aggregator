<?php

namespace App\Orchid\Screens\Geo\City;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CityEditScreen extends Screen
{
    public ?City $city;

    /**
     * @return array
     */
    public function query( City $city ) : iterable
    {
        return [
            'city' => $city,
            'place' => [
                'lat' => $city?->lat ?? 0.0,
                'lng' => $city?->lon ?? 0.0,
            ]
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->city->exists
            ? 'Редактирование города'
            : 'Добавить новый город';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.geo.cities',
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
                ->canSee( $this->city->exists ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.geo.cities' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows( [
                Input::make( 'city.alias' )
                    ->type( 'text' )
                    ->max( 128 )
                    ->title( 'Уникальный ЧПУ города' )
                    ->required()
                    ->style( 'max-width: inherit' ),

                Select::make( 'city.country_id' )
                    ->options(
                        Country::get()
                            ->map( function( $item ) {
                                return [ 'id' => $item->id, 'name' => $item->name[ 'ru' ] ];
                            } )
                            ->pluck( 'name', 'id' )
                            ->toArray()
                    )
                    ->empty( '' )
                    ->title( 'Страна' )
                    ->required(),

                Group::make( [
                    Input::make( 'city.name.ru' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название города [RU]' )
                        ->required(),

                    Input::make( 'city.name.en' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название города [EN]' )
                        ->required(),
                ] ),

                Group::make( [
                    CheckBox::make( 'city.has_metro' )
                        ->sendTrueOrFalse()
                        ->title( 'Есть метро' ),
                ] ),

                Input::make( 'city.population' )
                    ->type( 'number' )
                    ->title( 'Количество населения' )
                    ->style( 'max-width: inherit' ),

                Map::make( 'place' )
                    ->title( 'Центр города' ),
            ] )
        ];
    }

    /**
     * @param City $city
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate( City $city, Request $request ) : RedirectResponse
    {
        $input  = $request->collect( 'city' );
        $insert = $input->only( [
            'alias',
            'country_id',
            'name',
            'has_metro',
            'show_in_filter',
            'population',
        ] )->toArray();

        $insert[ 'lat' ] = $request->get( 'place', [] )[ 'lat' ] ?? 0.0;
        $insert[ 'lon' ] = $request->get( 'place', [] )[ 'lng' ] ?? 0.0;

        $city->fill( $insert );
        $city->save();

        Toast::info(
            !( $city->id !== null )
                ? 'Вы успешно добавили новый город'
                : 'Вы успешно обновили город'
        )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.geo.cities' );
    }

    public function remove( City $model )
    {
        $model->delete();
        Toast::info( __( 'Город удалена' ) );

        return redirect()->route('platform.geo.cities');
    }
}
