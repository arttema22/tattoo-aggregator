<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{

    /**
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'reviews', static function ( Blueprint $table ) {
            $table->id();

            $table->unsignedBigInteger( 'contact_id' );
            $table->string( 'name', 255 );
            $table->text( 'content' );
            $table->timestamp( 'published_at' )->nullable();
            $table->unsignedTinyInteger( 'type' )->default( 0 );
            $table->unsignedTinyInteger( 'is_approved' )->default( 0 );

            $table->timestamps();
        } );
    }

    /**
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'reviews' );
    }
}
