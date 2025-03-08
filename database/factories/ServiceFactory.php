<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'profile_id'     => Profile::factory(),
            'name'           => $this->faker->sentence,
            'type'           => $this->faker->randomElement( [
                \App\Enums\SpecializationTypes::TATTOO,
                \App\Enums\SpecializationTypes::TATUAJE,
                \App\Enums\SpecializationTypes::PIERCING,
                \App\Enums\SpecializationTypes::OTHER,
            ] ),
            'price'          => $this->faker->randomFloat( 2, 100, 50000 ),
            'currency'       => 'RUB',
            'status'         => 1,
            'is_start_price' => (int) $this->faker->boolean( 90 ),
        ];
    }

    /**
     * @param \App\Models\Profile $profile
     * @return \Database\Factories\ServiceFactory
     */
    public function profile( Profile $profile ) : self
    {
        return $this->state( function () use ( $profile ) {
            return [
                'profile_id' => $profile->id
            ];
        } );
    }
}
