<?php

namespace App\Helpers;

class WeekdayHelper
{
    public const DAYS_OF_WEEK = 7;

    private const RUSSIAN_WEEKDAYS = [
        1 => 'пн',
        2 => 'вт',
        3 => 'ср',
        4 => 'чт',
        5 => 'пт',
        6 => 'сб',
        7 => 'вс',
    ];

    private const WEEKDAYS = [
        1 => 'mo',
        2 => 'tu',
        3 => 'we',
        4 => 'th',
        5 => 'fr',
        6 => 'sa',
        7 => 'su',
    ];

    /**
     * @param int $day
     * @return string
     */
    public static function convertToString( int $day ): string
    {
        if ( config( 'app.locale' ) === 'ru' ) {
            return self::RUSSIAN_WEEKDAYS[ $day ] ?? '';
        }

        return self::WEEKDAYS[ $day ] ?? '';
    }

    public static function getAllWeekDays(): array
    {
        return array_keys( self::WEEKDAYS );
    }
}
