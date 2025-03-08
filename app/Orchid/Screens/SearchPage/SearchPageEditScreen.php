<?php

namespace App\Orchid\Screens\SearchPage;

use App\Helpers\SpecialisationDictionaryHelper;
use App\Models\Dictionaries\Dictionary;
use App\Models\FilterPage;
use App\Orchid\Layouts\SearchPage\DictionaryLayout;
use App\Orchid\Layouts\SearchPage\SearchPageEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class SearchPageEditScreen extends Screen
{
    public ?FilterPage $model;

    /**
     * @return array
     */
    public function query( FilterPage $model ): iterable
    {
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
        return 'Редактирование поисковой странице';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.search-pages',
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
                ->route( 'platform.search-pages' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SearchPageEditLayout::class,
            DictionaryLayout::class,
        ];
    }

    public function update( FilterPage $page, Request $request ) : RedirectResponse
    {
        $data    = $request->get( 'page' );
        $filters = $request->get( 'dictionary' );
        $slug    = $this->getSlug( $filters );

        $data[ 'slug' ] = $slug;
        $data[ 'dictionary' ] = array_map( 'intval' , $filters);

        $page->fill( $data );
        $page->save();

        Toast::info( 'Поисковая страница успешно обновлена' )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.search-pages' );
    }

    public function remove( FilterPage $model )
    {
        $model->delete();
        Toast::info( __( 'Поисковая страница удалена' ) );

        return redirect()->route( 'platform.search-pages' );
    }

    protected function getSlug( array $filters ) : string
    {
        return Dictionary::whereIn( 'id', $filters )->orderBy( 'id' )->get()->pluck( 'slug' )->join( '_' );
    }
}
