<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'alias' => $this->faker->unique->uuid,
            'name'  => $this->faker->jobTitle
        ];
    }
}
