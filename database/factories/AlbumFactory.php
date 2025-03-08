<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumFactory extends Factory
{
    protected $model = Album::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'contact_id'  => Contact::factory(),
            'type'        => $this->faker->randomElement( [
                \App\Enums\SpecializationTypes::TATTOO,
                \App\Enums\SpecializationTypes::TATUAJE,
                \App\Enums\SpecializationTypes::PIERCING,
                \App\Enums\SpecializationTypes::OTHER,
            ] ),
            'name'        => $this->faker->randomElement( [ 'Tattoo', 'Tatuaje', 'Piercing', 'Other' ] ),
            'description' => $this->faker->text
        ];
    }

    /**
     * @param $name
     * @return $this
     */
    public function name( $name ) : self
    {
        return $this->state( function () use ( $name ) {
            return [
                'name' => $name,
            ];
        } );
    }
}
