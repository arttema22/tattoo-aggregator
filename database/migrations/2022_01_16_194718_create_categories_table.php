<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'categories', static function ( Blueprint $table ) {
            $table->id();
            $table->string( 'alias', 128 )->unique();
            $table->string( 'name', 255 );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'categories' );
    }
}
