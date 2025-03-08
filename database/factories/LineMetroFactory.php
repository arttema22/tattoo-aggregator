<?php

namespace Database\Factories;

use App\Models\LineMetro;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineMetroFactory extends Factory
{
    protected $model = LineMetro::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'name'  => [ $this->faker->domainName ],
            'color' => $this->faker->regexify( '[0-9A-F]{6}' )
        ];
    }
}
