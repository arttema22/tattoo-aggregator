<?php

namespace Database\Factories;

use App\Enums\SpecializationTypes;
use App\Models\City;
use App\Models\LandingPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandingPageFactory extends Factory
{
    protected $model = LandingPage::class;

    public function definition(): array
    {
        return [
            'slug'        => implode( '-', $this->faker->words( 3 ) ),
            'city_id'     => City::factory(),
            'type'        => $this->faker->randomElement( [
                SpecializationTypes::TATTOO,
                SpecializationTypes::TATUAJE,
                SpecializationTypes::PIERCING,
            ] ),
            'dictionary'  => [],
            'title'       => $this->faker->realTextBetween( 15, 30 ),
            'keywords'    => $this->faker->realTextBetween( 10, 100 ),
            'description' => $this->faker->realTextBetween( 20, 250 ),
            'seo_text'    => $this->faker->realTextBetween( 20, 600 ),
        ];
    }

    /**
     * @param City $city
     * @return LandingPageFactory
     */
    public function city( City $city ) : self
    {
        return $this->state( function () use ( $city ) {
            return [
                'city_id' => $city->id
            ];
        } );
    }
}
