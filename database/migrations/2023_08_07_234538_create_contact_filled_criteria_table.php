<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFilledCriteriaTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create( 'contact_filled_criteria', static function ( Blueprint $table ) {
            $table->id();
            $table->unsignedTinyInteger( 'type' );
            $table->unsignedTinyInteger( 'subtype' )->nullable();
            $table->unsignedTinyInteger( 'value' )->nullable();
            $table->unsignedTinyInteger( 'percent' )->default( 0 );
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists( 'contact_filled_criteria' );
    }
}
