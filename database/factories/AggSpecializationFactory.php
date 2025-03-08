<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class AggSpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'contact_id' => Contact::class,
            'type'       => 0,
            'attribute'  => []
        ];
    }

    public function contact( Contact $contact ) : self
    {
        return $this->state( function () use ( $contact ) {
            return [
                'contact_id' => $contact->id
            ];
        } );
    }
}
