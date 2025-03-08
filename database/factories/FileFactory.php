<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class FileFactory extends Factory
{
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array
    {
        return [
            'user_id'   => User::factory(),
            'thumbs'    => [],
            'size'      => $this->faker->randomNumber(),
            'mime_type' => $this->faker->mimeType()
        ];
    }

    /**
     * @param $w
     * @param $h
     * @param $category
     * @return FileFactory
     */
    public function image( $w, $h, $category ) : self
    {
        return $this->state( function () use ( $w, $h, $category ) {
            return [
                'original' => $this->faker->image( Storage::path( config( 'image.original.path' ) ), $w, $h, $category, false ),
            ];
        } );
    }

    /**
     * @param User $user
     * @return FileFactory
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
