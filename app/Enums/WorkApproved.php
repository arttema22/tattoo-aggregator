<?php

namespace App\Enums;

class WorkApproved
{
    public const WAIT    = 0;

    public const APPROVE = 1;

    public const REJECT  = 2;

    /**
     * @param int $id
     * @return string
     */
    public static function toName( int $id ) : string
    {
        return match ( $id ) {
            self::WAIT    => 'Ожидает модерации',
            self::APPROVE => 'Одобрено',
            self::REJECT  => 'Отклонено',
        };
    }

    /**
     * @return string[]
     */
    public static function names() : array
    {
        return [
            self::WAIT    => 'Ожидает модерации',
            self::APPROVE => 'Одобрено',
            self::REJECT  => 'Отклонено',
        ];
    }
}
