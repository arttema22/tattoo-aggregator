<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'articles', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' )->index();
            $table->string( 'alias', 255 )->unique();
            $table->string( 'title', 255 );
            $table->string( 'description', 255 );
            $table->text( 'content' );
            $table->timestamps();
            $table->timestamp( 'published_at' )->nullable();
            $table->timestamp( 'deleted_at' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'articles' );
    }
}
