<?php

namespace App\Orchid\Layouts\Salon;

use App\Helpers\WeekdayHelper;
use App\Models\Contact;
use App\Models\WorkingHours;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class WorkingHourTableLayout extends Table
{
    /**
     * @var string
     */
    protected $target = 'salon.workingHours';

    /**
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make( 'day', 'День' )
                ->render( function ( WorkingHours $model ) {
                    return WeekdayHelper::convertToString( $model->day );
                } ),

            TD::make( 'start', 'Открытие' )
                ->render( function ( WorkingHours $model ) {
                    if ( $model->is_weekend || $model->is_nonstop ) {
                        return '--:--';
                    }

                    return sprintf( '%02d:00', $model->start );
                } ),

            TD::make( 'end', 'Закрытие' )
                ->render( function ( WorkingHours $model ) {
                    if ( $model->is_weekend || $model->is_nonstop ) {
                        return '--:--';
                    }

                    return sprintf( '%02d:00', $model->end );
                } ),

            TD::make( 'is_weekend', 'Выходной' )
                ->render( function ( WorkingHours $model ) {
                    if ( $model->is_weekend ) {
                        return '<i class="fas fa-check"></i>';
                    }

                    return '-';
                } ),

            TD::make( 'is_nonstop', 'Круглосуточно' )
                ->render( function ( WorkingHours $model ) {
                    if ( $model->is_nonstop ) {
                        return '<i class="fas fa-check"></i>';
                    }

                    return '-';
                } ),

            TD::make( __( 'Actions' ) )
                ->align( TD::ALIGN_CENTER )
                ->width( '100px' )
                ->render( function ( WorkingHours $model ) {
                    return ModalToggle::make( '' )
                        ->icon( 'pencil' )
                        ->modal( 'asyncEditWorkingHourModal' )
                        ->modalTitle( 'Редактирование времени за ' . WeekdayHelper::convertToString( $model->day ) )
                        ->method( 'updateWorkingHour' )
                        ->asyncParameters( [
                            'id' => $model->id,
                        ] );
                } )
        ];
    }
}
