<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'users', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedTinyInteger( 'role' );
            $table->string( 'name', 255 );
            $table->string( 'email', 255 )->unique();
            $table->timestamp( 'email_verified_at' )->nullable();
            $table->string( 'password' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'users' );
    }
}
