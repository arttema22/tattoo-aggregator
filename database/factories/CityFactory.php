<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = City::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'country_id'     => 0,
            'alias'          => '',
            'name'           => [],
            'has_metro'      => 0,
            'show_in_filter' => 0,
            'population'     => 0,
            'lat'            => 0.0,
            'lon'            => 0.0,
        ];
    }

    public function country( Country $country ) : self
    {
        return $this->state( function () use ( $country ) {
            return [
                'country_id' => $country->id,
            ];
        } );
    }

    public function hasMetro( int $value ) : self
    {
        return $this->state( function () use ( $value ) {
            return [
                'has_metro' => $value,
            ];
        } );
    }
}
