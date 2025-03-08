<?php

namespace App\Orchid\Screens\Geo\Country;

use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CountryEditScreen extends Screen
{
    public ?Country $country;

    /**
     * @return array
     */
    public function query( Country $country ) : iterable
    {
        return [
            'country' => $country,
        ];
    }

    /**
     * @return string|null
     */
    public function name() : ?string
    {
        return $this->country->exists
            ? 'Редактирование страны'
            : 'Добавить новую страну';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.geo.countries',
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
                ->canSee( $this->country->exists ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.geo.countries' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows( [
                Input::make( 'country.iso' )
                    ->type( 'text' )
                    ->max( 2 )
                    ->title( 'ISO код страны' )
                    ->required()
                    ->style( 'max-width: inherit' ),

                Group::make( [
                    Input::make( 'country.name.ru' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название страны [RU]' )
                        ->required(),

                    Input::make( 'country.name.en' )
                        ->type( 'text' )
                        ->max( 120 )
                        ->title( 'Название страны [EN]' )
                        ->required(),
                ] )
            ] )
        ];
    }

    /**
     * @param Country $country
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate( Country $country, Request $request ) : RedirectResponse
    {
        $input  = $request->collect( 'country' );
        $insert = $input->only( [
            'iso',
            'name',
        ] )->toArray();

        $country->fill( $insert );
        $country->save();

        Toast::info(
            !( $country->id !== null )
                ? 'Вы успешно добавили новую страну'
                : 'Вы успешно обновили страну'
        )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.geo.countries' );
    }

    public function remove( Country $model )
    {
        $model->delete();
        Toast::info( __( 'Страна удалена' ) );

        return redirect()->route('platform.geo.cities');
    }
}
