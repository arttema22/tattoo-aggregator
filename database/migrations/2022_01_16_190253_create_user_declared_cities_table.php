<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDeclaredCitiesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'user_declared_cities', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'user_id' )->index();
            $table->string( 'name', 255 );
            // 0 - n/a, 1 - new, 2 - approved, 3 - rejected
            $table->unsignedTinyInteger( 'status' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'user_declared_cities' );
    }
}
