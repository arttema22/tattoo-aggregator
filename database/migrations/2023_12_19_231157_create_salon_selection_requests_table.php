<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalonSelectionRequestsTable extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create( 'salon_selection_requests', static function ( Blueprint $table ) {
            $table->id();
            $table->jsonb( 'types' );
            $table->unsignedBigInteger( 'city_id' );
            $table->string( 'phone', 64 );
            $table->text( 'description' )->default( '' );
            $table->boolean( 'is_mail_sent' )->default( false );
            $table->unsignedBigInteger( 'landing_page_id' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists( 'salon_selection_requests' );
    }
}
