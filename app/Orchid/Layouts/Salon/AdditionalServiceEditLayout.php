<?php

namespace App\Orchid\Layouts\Salon;

use App\Models\AdditionalServiceName;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class AdditionalServiceEditLayout extends Rows
{
    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $output = [];
        $ads    = $this->query[ 'salon' ]->additionalServices;

        foreach ( AdditionalServiceName::get() as $item ) {
            $current = $ads->where( 'as_id', '=', $item->id );
            $output[] = CheckBox::make( 'additionalServices[' . $item->id . '][as_id]' )
                    ->title( $item->name )
                    ->checked( $current->isNotEmpty() )
                    ->value( $item->id )
                    ->horizontal();
            $output[] = Input::make( 'additionalServices[' . $item->id . '][id]' )
                    ->type( 'hidden' )
                    ->value( $current->first()?->id ?? 0 )
                    ->hidden();
        }

        return $output;
    }
}
