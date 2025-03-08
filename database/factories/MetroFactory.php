<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\LineMetro;
use App\Models\Metro;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetroFactory extends Factory
{
    protected $model = Metro::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'lat'      => $this->faker->latitude,
            'lon'      => $this->faker->longitude,
            'position' => $this->faker->randomDigit()
        ];
    }

    /**
     * @param City $city
     * @return $this
     */
    public function city( City $city ) : self
    {
        return $this->state( function () use ( $city ) {
            return [
                'city_id' => $city->id
            ];
        } );
    }

    /**
     * @param LineMetro $line
     * @return $this
     */
    public function line( LineMetro $line ) : self
    {
        return $this->state( function () use ( $line ) {
            return [
                'line_id' => $line->id
            ];
        } );
    }
}
