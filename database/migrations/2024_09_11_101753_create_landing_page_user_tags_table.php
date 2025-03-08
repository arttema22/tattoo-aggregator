<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageUserTagsTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create( 'landing_page_user_tags', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'landing_page_id' );
            $table->string( 'name', 255 );
            $table->string( 'link', 1024 );
            $table->timestamps();
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists( 'landing_page_user_tags' );
    }
}
