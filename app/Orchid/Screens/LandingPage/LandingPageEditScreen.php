<?php

namespace App\Orchid\Screens\LandingPage;

use App\Enums\ModelsRelations\LandingPageRelations;
use App\Helpers\SpecialisationDictionaryHelper;
use App\Models\Dictionaries\Dictionary;
use App\Models\LandingPage;
use App\Models\LandingPageService;
use App\Models\LandingPageTag;
use App\Models\LandingPageUserTag;
use App\Orchid\Layouts\LandingPage\LandingPageEditLayout;
use App\Orchid\Layouts\LandingPage\DictionaryLayout;
use App\Orchid\Layouts\LandingPage\ServiceEditLayout;
use App\Orchid\Layouts\LandingPage\ServicesTableLayout;
use App\Orchid\Layouts\LandingPage\TagEditLayout;
use App\Orchid\Layouts\LandingPage\TagsTableLayout;
use App\Orchid\Layouts\LandingPage\UserTagEditLayout;
use App\Orchid\Layouts\LandingPage\UserTagsTableLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class LandingPageEditScreen extends Screen
{
    public ?LandingPage $model;

    /**
     * @return array
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function query( LandingPage $model ): iterable
    {
        $model->load( [
            LandingPageRelations::CITY,
            LandingPageRelations::TAG,
            LandingPageRelations::SERVICES,
            LandingPageRelations::USER_TAG,
        ] );
        $this->model = $model;

        return [
            'page'         => $model,
            'dictionary'   => $model->dictionary,
            'dictionaries' => current( SpecialisationDictionaryHelper::get( $model->type ) )
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование Landing page';
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
                ->method( 'update' ),

            Button::make( 'Удалить' )
                ->icon( 'trash' )
                ->method( 'remove' ),

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
            // форма редактирования основной информации
            LandingPageEditLayout::class,

            // таблица с прайсом (оказываемые услуги)
            Layout::block( ServicesTableLayout::class )
                ->title( 'Прайс лист услуг' )
                ->vertical()
                ->commands( [
                    ModalToggle::make( __( 'Добавить' ) )
                        ->icon( 'plus' )
                        ->type( Color::DEFAULT() )
                        ->modal( 'asyncAddServiceModal' )
                        ->modalTitle( 'Добавить' )
                        ->method( 'addService' )
                        ->asyncParameters( [
                            'landing_page_id' => $this->model?->id ?? 0
                        ] )
                ] ),

            // Теги страницы, для отображения на других страницах
            Layout::block( TagsTableLayout::class )
                ->title( 'Теги страницы' )
                ->description( 'Теги страницы будут отображаться на других Landing page для перелинковки.' )
                ->commands( [
                    ModalToggle::make( __( 'Добавить' ) )
                        ->icon( 'plus' )
                        ->type( Color::DEFAULT() )
                        ->modal( 'asyncAddTagModal' )
                        ->modalTitle( 'Добавить тег' )
                        ->method( 'addTag' )
                        ->asyncParameters( [
                            'landing_page_id' => $this->model?->id ?? 0
                        ] )
                ] ),

            // Теги страницы, которые будут отображаться на этой странице
            Layout::block( UserTagsTableLayout::class )
                ->title( 'Пользовательские теги страницы' )
                ->description( 'Теги которые окажутся на странице. Задаются пользователем на любые страницы или внешние источники.' )
                ->commands( [
                    ModalToggle::make( __( 'Добавить' ) )
                        ->icon( 'plus' )
                        ->type( Color::DEFAULT() )
                        ->modal( 'asyncAddUserTagModal' )
                        ->modalTitle( 'Добавить тег' )
                        ->method( 'addUserTag' )
                        ->asyncParameters( [
                            'landing_page_id' => $this->model?->id ?? 0
                        ] )
                ] ),

            // фильтры картинок что будут отображаться
            Layout::block( DictionaryLayout::class )
                ->title( 'Фильтры галереи' )
                ->description( 'Данные фильтры нужно согласовывать с заголовком страницы, чтобы галерея работ отображалась по теме.' ),

            // Модалки на добавление/редактирование тегов страницы
            Layout::modal( 'asyncEditTagModal', TagEditLayout::class )
                ->async( 'asyncGetTag' ),
            Layout::modal( 'asyncAddTagModal', TagEditLayout::class ),

            // Модалки на добавление/редактирование тегов пользователей для страницы
            Layout::modal( 'asyncEditUserTagModal', UserTagEditLayout::class )
                ->async( 'asyncGetUserTag' ),
            Layout::modal( 'asyncAddUserTagModal', UserTagEditLayout::class ),

            // Модалки на добавление/редактирование оказываемых услуг
            Layout::modal( 'asyncEditServiceModal', ServiceEditLayout::class )
                ->async( 'asyncGetService' ),
            Layout::modal( 'asyncAddServiceModal', ServiceEditLayout::class ),
        ];
    }

    public function update( LandingPage $page, Request $request ) : RedirectResponse
    {
        $data    = $request->get( 'page' );
        $filters = $request->get( 'dictionary' );

        $data[ 'dictionary' ] = array_map( 'intval' , $filters);

        $page->fill( $data );
        $page->save();

        Toast::info( 'Landing page успешно обновлена' )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.landing-pages' );
    }

    public function remove( LandingPage $model )
    {
        $model->delete();
        Toast::info( __( 'Landing page удалена' ) );

        return redirect()->route( 'platform.landing-pages' );
    }

    // ======================================================================

    public function asyncGetTag( LandingPageTag $model ) : iterable
    {
        return [
            'tag' => $model
        ];
    }

    public function updateTag( Request $request ) : void
    {
        $tag = LandingPageTag::find( $request->get( 'id' ) );
        if ( $tag === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        $tag->fill(
            $request
                ->collect( 'tag' )
                ->only( [
                    'name',
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Тег успешно обновлен' ) );
    }

    public function addTag( Request $request ) : void
    {
        $model  = LandingPageTag::make();
        $insert = $request
            ->collect( 'tag' )
            ->only( [
                'name',
            ] )
            ->toArray();
        $insert[ 'landing_page_id' ] = $request->get( 'landing_page_id' );

        $model->fill( $insert )->save();

        Toast::info( __( 'Тег успешно добавлен' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function removeTag( Request $request ): void
    {
        LandingPageTag::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Тег удален' ) );
    }

    // ======================================================================

    public function asyncGetUserTag( LandingPageUserTag $model ) : iterable
    {
        return [
            'user-tag' => $model
        ];
    }

    public function updateUserTag( Request $request ) : void
    {
        $tag = LandingPageUserTag::find( $request->get( 'id' ) );
        if ( $tag === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        $tag->fill(
            $request
                ->collect( 'user-tag' )
                ->only( [
                    'name',
                    'link',
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Пользовательский тег успешно обновлен' ) );
    }

    public function addUserTag( Request $request ) : void
    {
        $model  = LandingPageUserTag::make();
        $insert = $request
            ->collect( 'user-tag' )
            ->only( [
                'name',
                'link',
            ] )
            ->toArray();
        $insert[ 'landing_page_id' ] = $request->get( 'landing_page_id' );

        $model->fill( $insert )->save();

        Toast::info( __( 'Пользовательский тег успешно добавлен' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function removeUserTag( Request $request ): void
    {
        LandingPageUserTag::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Пользовательский тег удален' ) );
    }

    // ======================================================================

    /**
     * @param LandingPageService $service
     * @return iterable
     */
    public function asyncGetService( LandingPageService $service ) : iterable
    {
        return [
            'service' => $service
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateService( Request $request ) : void
    {
        $service = LandingPageService::find( $request->get( 'id' ) );
        if ( $service === null ) {
            Toast::error( __( 'Услуга не найдена' ) );
            return;
        }

        $service->fill(
            $request
                ->collect( 'service' )
                ->only( [
                    'name',
                    'type',
                    'price',
                    'currency',
                    'is_start_price',
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Услуга успешно обновлена' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function addService( Request $request ) : void
    {
        $model  = LandingPageService::make();
        $insert = $request
            ->collect( 'service' )
            ->only( [
                'name',
                'type',
                'price',
                'currency',
                'is_start_price',
            ] )
            ->toArray();
        $insert[ 'landing_page_id' ] = $request->get( 'landing_page_id' );

        $model->fill( $insert )->save();

        Toast::info( __( 'Услуга успешно добавлена' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function removeService( Request $request ): void
    {
        LandingPageService::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Услуга удалена' ) );
    }

    // ======================================================================
}
