<?php

namespace App\Orchid\Layouts\Salon;

use App\Models\SocialNetworkName;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class SocialEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Select::make( 'social.sn_id' )
                ->fromModel( SocialNetworkName::class, 'name', 'id' )
                ->empty( '' )
                ->title( 'Социальная сеть' )
                ->required(),

            Input::make( 'social.value' )
                ->max( 255 )
                ->type( 'text' )
                ->title( 'Значение' )
                ->required()
        ];
    }
}
