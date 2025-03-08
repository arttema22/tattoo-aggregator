<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'working_hours', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedBigInteger( 'profile_id' );
            $table->unsignedBigInteger( 'contact_id' )->nullable();
            // 0 - n/a, 1 - monday ... 7 - sunday
            $table->unsignedTinyInteger( 'day' )->default( 0 );
            $table->unsignedTinyInteger( 'start' )->nullable();
            $table->unsignedTinyInteger( 'end' )->nullable();
            // 0 - false, 1 - true
            $table->unsignedTinyInteger( 'is_weekend' )->default( 0 );
            // 0 - false, 1 - true
            $table->unsignedTinyInteger( 'is_nonstop' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists( 'working_hours' );
    }
}
