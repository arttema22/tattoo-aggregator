<?php

namespace App\Orchid\Screens\Article;

use App\DTO\File\FileDTO;
use App\Events\UploadedImageEvent;
use App\Models\Article;
use App\Orchid\Layouts\Article\ContentEditLayout;
use App\Orchid\Layouts\Article\CoverEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Models\File as Pic;

class ArticleEditScreen extends Screen
{
    public ?Article $article;

    /**
     * @return array
     */
    public function query( Article $article ): iterable
    {
        $article->load( [ 'banner' ] );

        return [
            'article' => $article
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->article->exists
            ? 'Редактирование статьи'
            : 'Добавить новую статью';
    }

    public function description(): ?string
    {
        return 'Статья для отображения в блоге';
    }

    /**
     * @return iterable|null
     */
    public function permission() : ?iterable
    {
        return [
            'platform.articles',
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
                ->canSee( $this->article->exists ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.articles' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs( [
                'Статья'  => ContentEditLayout::class,
                'Обложка' => CoverEditLayout::class,
            ] )
        ];
    }

    public function createOrUpdate( Article $article, Request $request ) : RedirectResponse
    {
        $article->load( [ 'banner' ] );
        $input = $request->collect( 'article' );
        $insert = $input->only( [
            'alias',
            'title',
            'description',
            'content'
        ] )->toArray();

        $article->fill( $insert );
        $is_exist = $article->id !== null;
        if (!$is_exist) {
            $article->user_id = Auth::user()->id;
        }
        $article->save();

        if ( $input->has( 'categories' ) ) {
            $article->categories()->sync( $input->get( 'categories' ) );
        }

        // сохранение обложки
        $banner = $input->get( 'banner' )[ 'url' ] ?? '';
        if ( $banner !== '' && !str_contains( $banner, 'original' ) ) {
            // анализируем и сохраняем в новом месте
            $new_banner   = Attachment::where( 'name', '=', pathinfo( $banner, PATHINFO_FILENAME ) )->first();
            $path_to_file = Storage::disk($new_banner->disk)->path($new_banner->physicalPath());
            $new_path     = storage_path( '/app/images/original/' . basename( $banner ) );
            File::copy( $path_to_file, $new_path );

            // создаем запись в нужной таблице и связываем с этой статьей
            $file = Pic::make( [
                'original'  => basename( $banner ),
                'size'      => $new_banner->size,
                'mime_type' => $new_banner->mime,
                'thumbs'    => [],
            ] );
            $file->user_id = Auth::user()->id;
            $file->fileable()->associate( $article )->save();

            // удаляем временный файл
            $new_banner->delete();

            // создание задачи для мелких картинок
            $dto = FileDTO::fromModel( $file );
            UploadedImageEvent::dispatch( $dto );
        }

        // удаление обложки
        if ( $banner === '' && $article->banner !== null ) {
            $article->banner()->delete();
        }

        Toast::info(
            !$is_exist
                ? 'Вы успешно добавили новую статью'
                : 'Вы успешно обновили статью'
        )->autoHide()->delay( 2000 );

        return redirect()->route( 'platform.articles' );
    }

    public function remove( Article $model )
    {
        $model->delete();
        Toast::info( __( 'Статья удалена' ) );

        return redirect()->route('platform.articles');
    }
}
