<?php

namespace App\Orchid\Screens\LandingPage;

use App\Helpers\SpecialisationDictionaryHelper;
use App\Models\LandingPage;
use App\Orchid\Layouts\LandingPage\LandingPageEditLayout;
use App\Orchid\Layouts\LandingPage\DictionaryLayout;
use App\Services\LandingPageDefaultPriceService;
use App\Services\LandingPagePriceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class LandingPageAddScreen extends Screen
{
    protected int $type;

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function query( int $type ): iterable
    {
        $this->type = $type;

        return [
            'type'         => $type,
            'dictionaries' => current( SpecialisationDictionaryHelper::get( $this->type ) )
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Добавить новую Landing page';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.landing-pages',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make( 'Сохранить' )
                ->icon( 'save' )
                ->method( 'create' ),

            Link::make( 'Отмена' )
                ->icon( 'action-undo' )
                ->route( 'platform.landing-pages' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            LandingPageEditLayout::class,

            Layout::block( DictionaryLayout::class )
                ->title( 'Фильтры галереи' )
                ->description( 'Данные фильтры нужно согласовывать с заголовком страницы, чтобы галерея работ отображалась по теме.' ),
        ];
    }

    public function create( Request $request ) : RedirectResponse
    {
        $page    = $request->get( 'page' );
        $filters = $request->get( 'dictionary' );

        $page[ 'dictionary' ] = array_map( 'intval' , $filters );
        $model = LandingPage::make();
        $result = $model->fill( $page )->save();

        // заполнение новой страницы прайс-листом
        $prices = app(LandingPageDefaultPriceService::class)->get($page['type'], $page['city_id']);
        app(LandingPagePriceService::class)->fill($model->id, $model->type, $prices);

        if ( $result ) {
            Toast::info( 'Вы успешно добавили новую Landing page' )->autoHide()->delay( 2000 );
            return redirect()->route( 'platform.landing-pages.edit', [ 'page' => $model->id ] );
        } else {
            Toast::error( 'Не удалось создать новую Landing page' )->autoHide()->delay( 2000 );
            return redirect()->route( 'platform.landing-pages' );
        }
    }
}
