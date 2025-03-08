<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition(): array
    {
        return [
            'name'    => $this->faker->name,
            'phone'   => $this->faker->phoneNumber,
            'email'   => $this->faker->email,
            'message' => $this->faker->text(),
        ];
    }
}
