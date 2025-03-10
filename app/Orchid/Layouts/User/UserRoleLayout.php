<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserRoleLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('user.role')
                ->options( [
                    1 => 'Администратор',
                    2 => 'Модератор',
                    3 => 'Салон/Мастер',
                ] )
                ->title(__('Name role'))
                ->help('Specify which groups this account should belong to'),
        ];
    }
}
