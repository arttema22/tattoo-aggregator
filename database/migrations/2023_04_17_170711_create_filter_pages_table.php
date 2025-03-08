<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterPagesTable extends Migration
{
    /**
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'filter_pages', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'type' );
            $table->string( 'slug', 255 );
            $table->string( 'title', 255 );
            $table->string( 'description', 255 );
            $table->string( 'keywords', 255 );
            $table->jsonb('dictionary');
            $table->timestamps();

            $table->unique( [
                'type',
                'slug',
            ] );
        } );
    }

    /**
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'filter_pages' );
    }
}
