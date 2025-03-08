<?php

namespace App\Orchid\Filters\SearchPage;

use App\Enums\SpecializationTypes;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TypeFilter extends Filter
{
    protected array $options = [
        SpecializationTypes::TATTOO   => 'Татуировки',
        SpecializationTypes::TATUAJE  => 'Татуаж',
        SpecializationTypes::PIERCING => 'Пирсинг',
    ];

    /**
     * @return string
     */
    public function name(): string
    {
        return 'Тип';
    }

    /**
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [ 'type' ];
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where( 'type', '=', $this->request->get( 'type' ) );
    }

    /**
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make( 'type' )
                ->options( $this->options )
                ->empty( '' )
                ->title( 'Тип' )
        ];
    }

    public function value() : string
    {
        return $this->name() . ': ' . $this->options[ (int) $this->request->get( 'type' ) ];
    }
}
