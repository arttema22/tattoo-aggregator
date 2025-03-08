<?php

namespace App\Orchid\Layouts\Image;

use App\Helpers\SpecialisationDictionaryHelper;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Block;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class ImageViewLayout extends Legend
{
    protected function columns() : iterable
    {
        return [
            Sight::make()
                ->render( function ( $model ) {
                    return sprintf( '<div><img class="img-fluid" alt="preview" src="/storage/images/original/%s"></div>', $model[ 'original' ] );
                } )
        ];
    }
}
