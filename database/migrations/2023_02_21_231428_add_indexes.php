<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up() : void
    {
        Schema::table( 'additional_services', static function ( Blueprint $table ) {
            $table->index( 'profile_id' );
            $table->index( 'contact_id' );
        } );

        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->index( 'country_id' );
            $table->index( 'city_id' );
            $table->index( 'metro_id' );
        } );

        Schema::table( 'file_info', static function ( Blueprint $table ) {
            $table->index( 'file_id' );
        } );

        Schema::table( 'reviews', static function ( Blueprint $table ) {
            $table->index( 'contact_id' );
        } );

        Schema::table( 'service_to_contacts', static function ( Blueprint $table ) {
            $table->index( 'service_id' );
            $table->index( 'contact_id' );
        } );

        Schema::table( 'services', static function ( Blueprint $table ) {
            $table->index( 'profile_id' );
        } );

        Schema::table( 'social_networks', static function ( Blueprint $table ) {
            $table->index( 'profile_id' );
            $table->index( 'contact_id' );
        } );

        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->index( 'profile_id' );
            $table->index( 'contact_id' );
        } );

        Schema::table( 'working_hours', static function ( Blueprint $table ) {
            $table->index( 'profile_id' );
            $table->index( 'contact_id' );
        } );
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down() : void
    {
        Schema::table( 'additional_services', static function ( Blueprint $table ) {
            $table->dropIndex( 'profile_id' );
            $table->dropIndex( 'contact_id' );
        } );

        Schema::table( 'contacts', static function ( Blueprint $table ) {
            $table->dropIndex( 'country_id' );
            $table->dropIndex( 'city_id' );
            $table->dropIndex( 'metro_id' );
        } );

        Schema::table( 'file_info', static function ( Blueprint $table ) {
            $table->dropIndex( 'file_id' );
        } );

        Schema::table( 'reviews', static function ( Blueprint $table ) {
            $table->dropIndex( 'contact_id' );
        } );

        Schema::table( 'service_to_contacts', static function ( Blueprint $table ) {
            $table->dropIndex( 'service_id' );
            $table->dropIndex( 'contact_id' );
        } );

        Schema::table( 'services', static function ( Blueprint $table ) {
            $table->dropIndex( 'contact_id' );
        } );

        Schema::table( 'social_networks', static function ( Blueprint $table ) {
            $table->dropIndex( 'profile_id' );
            $table->dropIndex( 'contact_id' );
        } );

        Schema::table( 'videos', static function ( Blueprint $table ) {
            $table->dropIndex( 'profile_id' );
            $table->dropIndex( 'contact_id' );
        } );

        Schema::table( 'working_hours', static function ( Blueprint $table ) {
            $table->dropIndex( 'profile_id' );
            $table->dropIndex( 'contact_id' );
        } );
    }
}
