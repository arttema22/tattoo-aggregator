<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() : void
    {
        File::lines( __DIR__ . '/../data/category/categories.txt' )->each( function ( $item ) {
            if ( $item === '' ) {
                return;
            }

            [ $alias, $name ] = explode( ';', $item, 2 );
            Category::factory()
                ->state( [
                    'name'  => $name,
                    'alias' => $alias,
                ] )
                ->create();
        } );
    }
}
