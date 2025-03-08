<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactIdInServicesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'services', static function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'contact_id' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'services', static function ( Blueprint $table ) {
            $table->dropColumn( 'contact_id' );
        } );
    }
}
