<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Profile;
use App\Models\SocialNetwork;
use App\Models\SocialNetworkName;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialNetworkFactory extends Factory
{
    protected $model = SocialNetwork::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'profile_id' => Profile::factory(),
            'contact_id' => null,
            'sn_id'      => SocialNetworkName::factory(),
            'value'      => $this->faker->domainWord,
            'status'     => 1
        ];
    }

    /**
     * @param Profile $profile
     * @return SocialNetworkFactory
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
     * @return SocialNetworkFactory
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
     * @param SocialNetworkName $social_network_name
     * @return SocialNetworkFactory
     */
    public function socialNetwork( SocialNetworkName $social_network_name ) : self
    {
        return $this->state( function () use ( $social_network_name ) {
            return [
                'sn_id' => $social_network_name->id
            ];
        } );
    }
}
