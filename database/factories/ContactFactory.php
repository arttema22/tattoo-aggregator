<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Metro;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'profile_id' => 0,
            'country_id' => 0,
            'city_id'    => 0,
            'metro_id'   => 0,
            'alias'      => $this->faker->unique->uuid,
            'name'       => $this->faker->realText( 30 ),
            'address'    => $this->faker->address,
            'phone'      => $this->faker->phoneNumber,
            'site'       => $this->faker->domainName,
            'email'      => $this->faker->email,
            'district'   => $this->faker->words( 3, true ),
            'lat'        => $this->faker->latitude,
            'lon'        => $this->faker->longitude
        ];
    }

    /**
     * @param \App\Models\Profile $profile
     * @return \Database\Factories\ContactFactory
     */
    public function profile( Profile $profile ) : self
    {
        return $this->state( function () use ( $profile ) {
            return [
                'profile_id' => $profile->id
            ];
        } );
    }

    /**
     * @param \App\Models\Country $country
     * @return \Database\Factories\ContactFactory
     */
    public function country( Country $country ) : self
    {
        return $this->state( function () use ( $country ) {
            return [
                'country_id' => $country->id
            ];
        } );
    }

    /**
     * @param \App\Models\City $city
     * @return \Database\Factories\ContactFactory
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
     * @param \App\Models\Metro|null $metro
     * @return \Database\Factories\ContactFactory
     */
    public function metro( ?Metro $metro ) : self
    {
        return $this->state( function () use ( $metro ) {
            return $metro !== null
                ? [
                    'metro_id' => $metro->id
                ]
                : [];
        } );
    }
}
