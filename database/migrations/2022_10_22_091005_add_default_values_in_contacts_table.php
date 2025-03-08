<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValuesInContactsTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->boolean( 'country_id' )->nullable()->change();
            $table->boolean( 'city_id' )->nullable()->change();

            $table->softDeletes();
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->boolean( 'country_id' )->nullable( false )->change();
            $table->boolean( 'city_id' )->nullable( false )->change();

            $table->dropSoftDeletes();
        } );
    }
}
