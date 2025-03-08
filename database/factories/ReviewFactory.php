<?php

namespace Database\Factories;

use App\Enums\ReviewApprove;
use App\Enums\ReviewType;
use App\Models\Contact;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition() : array
    {
        return [
            'contact_id'  => Contact::factory(),
            'name'        => $this->faker->name,
            'content'     => $this->faker->realTextBetween( 20, 600 ),
            'type'        => ReviewType::AUTO,
            'is_approved' => random_int( 0, 10 ) > 9 ? ReviewApprove::NO : ReviewApprove::YES,
            'published_at'=> $this->faker->dateTimeBetween( '-1 year' )
        ];
    }

    /**
     * @param \App\Models\Contact $contact
     * @return $this
     */
    public function contact( Contact $contact ) : self
    {
        return $this->state( function () use ( $contact ) {
            return [
                'contact_id' => $contact->id
            ];
        } );
    }
}
