<?php

namespace App\Orchid\Screens\Article;

use App\Models\Article;
use App\Orchid\Layouts\Article\ArticleListLayout;
use App\Orchid\Selection\ArticleSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ArticleListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'articles' => Article::with( [ 'categories', 'user' ] )
                ->filters()
                ->filtersApplySelection( ArticleSelection::class )
                ->defaultSort('id', 'desc')
                ->paginate( 50 ),
        ];
    }

    /**
     * Display header name.
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Статьи в блоге';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.articles',
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make( __( 'Add' ) )
                ->icon( 'plus' )
                ->route( 'platform.articles.create' ),
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
            ArticleSelection::class,
            ArticleListLayout::class
        ];
    }

    /**
     * @param Request $request
     */
    public function remove( Request $request ): void
    {
        Article::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Статья удалена' ) );
    }
}
