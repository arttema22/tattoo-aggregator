<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Profile;
use App\Models\WorkingHours;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkingHoursFactory extends Factory
{
    protected $model = WorkingHours::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'profile_id' => Profile::factory(),
            'contact_id' => null,
            'day'        => $this->faker->numberBetween( 1, 7 ),
            'start'      => $this->faker->numberBetween( 0, 10 ),
            'end'        => $this->faker->numberBetween( 18, 23 ),
            'is_weekend' => (int) $this->faker->boolean( 10 ),
            'is_nonstop' => (int) $this->faker->boolean( 5 ),
        ];
    }

    /**
     * @return WorkingHoursFactory
     */
    public function hasWeekend() : self
    {
        return $this->state( function ( array $attributes ) {
            return [
                'is_weekend' => 1,
                'is_nonstop' => 0,
                'start'      => 0,
                'end'        => 0
            ];
        } );
    }

    /**
     * @return WorkingHoursFactory
     */
    public function hasNonStop() : self
    {
        return $this->state( function ( array $attributes ) {
            return [
                'is_nonstop' => 1,
                'is_weekend' => 0,
                'start'      => 0,
                'end'        => 0
            ];
        } );
    }

    /**
     * @param Profile $profile
     * @return WorkingHoursFactory
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
     * @param Contact $contact
     * @return WorkingHoursFactory
     */
    public function contact( Contact $contact ) : self
    {
        return $this->state( function () use ( $contact ) {
            return [
                'contact_id' => $contact->id
            ];
        } );
    }

    /**
     * @param int $day
     * @return WorkingHoursFactory
     */
    public function day( int $day ) : self
    {
        return $this->state( function () use ( $day ) {
            return [
                'day' => $day
            ];
        } );
    }
}
