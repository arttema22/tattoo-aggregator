<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\FileInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileInfoFactory extends Factory
{
    protected $model = FileInfo::class;

    /**
     * Define the model's default state.
     * @return array
     */
    public function definition() : array
    {
        return [
            'file_id'         => File::factory(),
            'name'            => $this->faker->sentence,
            'description'     => $this->faker->text,
            'attribute'       => [],
            'is_downloadable' => 0,
            'is_adult'        => $this->faker->numberBetween( 0, 1 ),
            'is_approved'     => 1
        ];
    }

    /**
     * @return FileInfoFactory
     */
    public function notApproved() : self
    {
        return $this->state( function () {
            return [
                'is_approved' => 0
            ];
        } );
    }

    /**
     * @return FileInfoFactory
     */
    public function hasDownloadable() : self
    {
        return $this->state( function () {
            return [
                'is_downloadable' => 1
            ];
        } );
    }

    /**
     * @param File $file
     * @return FileInfoFactory
     */
    public function file( File $file ) : self
    {
        return $this->state( function () use ( $file ) {
            return [
                'file_id' => $file->id
            ];
        } );
    }
}
