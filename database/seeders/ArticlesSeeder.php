<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     * @throws \Exception
     */
    public function run() : void
    {
        $categories = Category::all();

        User::all()->random( 6 )->each( function ( User $user ) use ( $categories ) {
            $articles = Article::factory()
                ->user( $user )
                ->hasPublish()
                ->count( random_int( 1, 3 ) )
                ->create();

            $articles->each( function ( Article $article ) use ( $user, $categories ) {
                /** @var File $file */
                $file = File::factory()
                    ->image( 1280, 480, 'article' )
                    ->user( $user )
                    ->make();

                $file->fileable()->associate( $article )->save();

                // добавить категорию
                $article->categories()->attach( $categories->random()->id );
            } );
        } );
    }
}
