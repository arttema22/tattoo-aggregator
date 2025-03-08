<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldsTypeInWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'working_hours', static function ( Blueprint $table ) {
            $table->string( 'start', 5 )->nullable()->change();
            $table->string( 'end', 5 )->nullable()->change();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'working_hours', static function ( Blueprint $table ) {
            $table->unsignedTinyInteger( 'start' )->nullable()->change();
            $table->unsignedTinyInteger( 'end' )->nullable()->change();
        });
    }
}
