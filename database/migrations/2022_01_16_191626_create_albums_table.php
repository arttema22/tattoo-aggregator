<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'albums', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'contact_id' )->index();
            $table->unsignedBigInteger( 'type' )->default( 0 );
            $table->string( 'name', 255 );
            $table->mediumText( 'description' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'albums' );
    }
}
