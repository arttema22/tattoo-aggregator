<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'user_id' => User::factory(),
            'alias'   => $this->faker->unique->uuid,
            'title'   => $this->faker->realText( 20 ),
            'content' => '<p>' . $this->faker->realTextBetween . '<p>' .
                         '<p>' . $this->faker->realTextBetween . '<p>' .
                         '<p>' . $this->faker->realTextBetween . '<p>' .
                         '<p>' . $this->faker->realTextBetween . '<p>',
            'description' => $this->faker->realTextBetween
        ];
    }

    /**
     * @return ArticleFactory
     */
    public function hasPublish() : self
    {
        return $this->state( function () {
            return [
                'published_at' => $this->faker->date( 'Y-m-d H:i:s' ),
            ];
        } );
    }

    /**
     * @param User $user
     * @return ArticleFactory
     */
    public function user( User $user ) : self
    {
        return $this->state( function () use ( $user ) {
            return [
                'user_id' => $user->id
            ];
        } );
    }
}
