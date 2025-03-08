<?php

declare(strict_types=1);

namespace App\Orchid\Filters\User;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class RoleFilter extends Filter
{
    protected array $options = [
        1 => 'Администратор',
        2 => 'Модератор',
        3 => 'Салон/Мастер',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return __('Roles');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['role'];
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('role', '=', $this->request->get('role'));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('role')
                ->options($this->options)
                ->empty()
                ->value($this->request->get('role'))
                ->title(__('Roles')),
        ];
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name() . ': ' . $this->options[(int) $this->request->get('role')];
    }
}
