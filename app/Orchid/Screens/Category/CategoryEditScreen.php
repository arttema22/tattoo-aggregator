<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
    public ?Category $category;

    /**
     * Query data.
     *
     * @return array
     */
    public function query( Category $category ): iterable
    {
        return [
            'category' => $category
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->category->exists
            ? 'Редактирование категории'
            : 'Добавить новую категорию';
    }

    public function description(): ?string
    {
        return 'Категория для группирования статей в блоге';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.category',
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
            Button::make( 'Сохранить' )
                ->icon( 'pencil' )
                ->method( 'createOrUpdate' ),

            Button::make( 'Удалить' )
                ->icon( 'trash' )
                ->method( 'remove' )
                ->canSee( $this->category->exists ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.categories' ),
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
            CategoryEditLayout::class
        ];
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate( Category $category, Request $request ) : RedirectResponse
    {
        $input = $request->collect( 'category' );
        $insert = $input->only( [
            'alias',
            'name',
        ] )->toArray();

        $category->fill( $insert );
        $is_exist = $category->id !== null;
        $category->save();

        Toast::info(
            !$is_exist
                ? 'Вы успешно добавили новую категорию'
                : 'Вы успешно обновили категорию'
        )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.categories' );
    }

    public function remove( Category $model )
    {
        $model->delete();
        Toast::info( __( 'Категория удалена' ) );

        return redirect()->route('platform.categories');
    }
}
