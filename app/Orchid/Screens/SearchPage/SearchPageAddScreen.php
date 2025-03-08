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

class SearchPageAddScreen extends Screen
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
        return 'Добавить новую поисковой страницу';
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
                ->method( 'create' ),

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

    public function create( Request $request ) : RedirectResponse
    {
        $page    = $request->get( 'page' );
        $filters = $request->get( 'dictionary' );
        $slug    = $this->getSlug( $filters );

        $page[ 'slug' ] = $slug;
        $page[ 'dictionary' ] = array_map( 'intval' , $filters );
        $result = FilterPage::make( $page )->save();

        if ( $result ) {
            Toast::info( 'Вы успешно добавили новую поисковую страницу' )->autoHide()->delay( 2000 );
        } else {
            Toast::error( 'Не удалось создать новую поисковую страницу' )->autoHide()->delay( 2000 );
        }

        return redirect()->route( 'platform.search-pages' );
    }

    protected function getSlug( array $filters ) : string
    {
        return Dictionary::whereIn( 'id', $filters )->orderBy( 'id' )->get()->pluck( 'slug' )->join( '_' );
    }
}
