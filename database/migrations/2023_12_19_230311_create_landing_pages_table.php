<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPagesTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create( 'landing_pages', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'city_id' );
            $table->unsignedBigInteger( 'type' );
            $table->jsonb('dictionary');
            $table->string( 'title' );
            $table->text( 'keywords' )->default( '' );
            $table->text( 'description' )->default( '' );
            $table->text( 'seo_text' )->default( '' );
            $table->timestamps();
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists( 'landing_pages' );
    }
}
