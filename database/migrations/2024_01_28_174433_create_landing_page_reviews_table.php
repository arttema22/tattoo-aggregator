<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPageReviewsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'landing_page_reviews', static function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'landing_page_id' );
            $table->unsignedBigInteger( 'review_id' );

            $table->unique( [
                'landing_page_id',
                'review_id'
            ] );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'landing_page_reviews' );
    }
}
