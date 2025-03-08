<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'feedback', static function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name', 255 );
            $table->string( 'phone', 64 );
            $table->string( 'email', 255 );
            $table->mediumText( 'message' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'feedback' );
    }
}
