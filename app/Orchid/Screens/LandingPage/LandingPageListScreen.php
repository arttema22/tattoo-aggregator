<?php

namespace App\Orchid\Screens\LandingPage;

use App\Enums\SpecializationTypes;
use App\Models\Dictionaries\Dictionary;
use App\Models\LandingPage;
use App\Orchid\Layouts\LandingPage\LandingPageTableLayout;
use App\Orchid\Selection\LandingPageSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class LandingPageListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'pages' => LandingPage::filters()
                ->with( [ 'city' ] )
                ->filtersApplySelection( LandingPageSelection::class )
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
            'platform.landing-pages',
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Landing page';
    }

    /**
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Landing page - более оптимизированные под поисковики страницы, концентрирующие в себе максимально много полезной информации (салоны, галерею работ, теги, поисковые тексты)';
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
                        ->route( 'platform.landing-pages.create', [ 'type' => SpecializationTypes::TATTOO ] ),

                    Link::make( __( 'Татуаж' ) )
                        ->route( 'platform.landing-pages.create', [ 'type' => SpecializationTypes::TATUAJE ] ),

                    Link::make( __( 'Пирсинг' ) )
                        ->route( 'platform.landing-pages.create', [ 'type' => SpecializationTypes::PIERCING ] )
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
            LandingPageSelection::class,
            LandingPageTableLayout::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function remove( Request $request ): void
    {
        LandingPage::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Landing page удалён' ) );
    }
}
