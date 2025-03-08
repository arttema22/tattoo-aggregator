<?php

namespace App\Orchid\Screens\Dictionary;

use App\Models\Dictionaries\Dictionary;
use App\Orchid\Layouts\Dictionary\CurrentDictionaryTableLayout;
use App\Orchid\Layouts\Dictionary\DictionaryEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DictionaryEditScreen extends Screen
{
    protected int $type;

    /**
     * @return array
     */
    public function query( int $type ): iterable
    {
        $this->type = $type;

        return [
            'dictionaries' => Dictionary::where( 'type', '=', $type )->get()
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование словаря';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.dictionaries',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make( 'Добавить' )
                ->icon( 'plus' )
                ->modal( 'asyncAddDictionaryModal' )
                ->modalTitle( 'Добавить записи' )
                ->method( 'add' )
                ->asyncParameters( [
                    'type' => $this->type,
                ] ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.dictionaries' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CurrentDictionaryTableLayout::class,

            Layout::modal( 'asyncEditDictionaryModal', DictionaryEditLayout::class )
                ->async( 'asyncGetDictionary' ),

            Layout::modal( 'asyncAddDictionaryModal', DictionaryEditLayout::class ),
        ];
    }

    public function asyncGetDictionary( Dictionary $model ) : iterable
    {
        return [
            'dictionary' => $model,
        ];
    }

    public function update( Request $request ) : void
    {
        $dictionary = Dictionary::find( $request->get( 'id' ) );
        if ( $dictionary === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        $dictionary->fill(
            $request
                ->collect( 'dictionary' )
                ->only( [
                    'slug',
                    'name'
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Запись успешно обновлена' ) );
    }

    public function add( Request $request ) : void
    {
        $dictionary = Dictionary::make();

        $insert = $request
            ->collect( 'dictionary' )
            ->only( [
                'slug',
                'name'
            ] )
            ->toArray();
        $insert[ 'type' ] = $request->get( 'type' );

        $dictionary->fill( $insert )->save();

        Toast::info( __( 'Запись успешно добавлена' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function remove( Request $request ): void
    {
        Dictionary::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Запись удалена удален' ) );
    }
}
