<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'article_to_category', static function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'category_id' );
            $table->unsignedBigInteger( 'article_id' );

            $table->unique( [
                'category_id',
                'article_id'
            ] );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'article_to_category' );
    }
}
