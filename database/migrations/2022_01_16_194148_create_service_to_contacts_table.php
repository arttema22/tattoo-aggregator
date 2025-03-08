<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceToContactsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::create( 'service_to_contacts', static function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'service_id' );
            $table->unsignedTinyInteger( 'contact_id' );
            $table->decimal( 'price', 8, 2, true )->default( 0 );
            // 0 - false, 1 - true
            $table->unsignedTinyInteger( 'is_start_price' )->default( 0 );
            // 0 - n/a, 1 - on, 2 - off
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
        Schema::dropIfExists( 'service_to_contacts' );
    }
}
