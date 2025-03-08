<?php

namespace App\Orchid\Screens\SearchPage;

use App\Enums\SpecializationTypes;
use App\Models\Dictionaries\Dictionary;
use App\Models\FilterPage;
use App\Orchid\Layouts\SearchPage\SearchPageTableLayout;
use App\Orchid\Selection\SearchPageSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class SearchPageListScreen extends Screen
{
    /**
     * @return array
     */
    public function query(): iterable
    {
        return [
            'pages' => FilterPage::filters()
                ->filtersApplySelection( SearchPageSelection::class )
                ->paginate( 50 ),
            'dictionaries' => Dictionary::get()->pluck( 'name', 'id' )->toArray(),
        ];
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
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Поисковые страницы';
    }

    /**
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Посадочные страницы при поиске (фильтрации) работ. Нужны чтобы задавать более релевантные заголовки и описания.';
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            DropDown::make( __( 'Add' ) )
                ->icon( 'plus' )
                ->list( [
                    Link::make( __( 'Тату' ) )
                        ->route( 'platform.search-pages.create', [ 'type' => SpecializationTypes::TATTOO ] ),

                    Link::make( __( 'Татуаж' ) )
                        ->route( 'platform.search-pages.create', [ 'type' => SpecializationTypes::TATUAJE ] ),

                    Link::make( __( 'Пирсинг' ) )
                        ->route( 'platform.search-pages.create', [ 'type' => SpecializationTypes::PIERCING ] )
                ] )
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SearchPageSelection::class,
            SearchPageTableLayout::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function remove( Request $request ): void
    {
        FilterPage::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Поисковая страница удалена' ) );
    }
}
