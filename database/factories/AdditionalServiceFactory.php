<?php

namespace Database\Factories;

use App\Models\AdditionalService;
use App\Models\AdditionalServiceName;
use App\Models\Contact;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalServiceFactory extends Factory
{
    protected $model = AdditionalService::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'profile_id' => Profile::factory(),
            'contact_id' => Contact::factory(),
            'as_id'      => AdditionalServiceName::factory()
        ];
    }

    /**
     * @return \Database\Factories\AdditionalServiceFactory
     */
    public function withoutContact() : self
    {
        return $this->state( function () {
            return [
                'contact_id' => null,
            ];
        } );
    }

    /**
     * @param Profile $profile
     * @return AdditionalServiceFactory
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
     * @param AdditionalServiceName $name
     * @return AdditionalServiceFactory
     */
    public function service( AdditionalServiceName $name ) : self
    {
        return $this->state( function () use ( $name ) {
            return [
                'as_id' => $name->id
            ];
        } );
    }
}
