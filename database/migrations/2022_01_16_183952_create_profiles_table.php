<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'profiles', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' )->index();
            // 0 - n/a, 1 - master, 2 - salon
            $table->unsignedTinyInteger( 'type' )->default( 0 );
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
        Schema::dropIfExists( 'profiles' );
    }
}
