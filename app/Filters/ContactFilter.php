<?php

namespace App\Filters;

use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ContactFilter extends QueryFilter
{
    use FilteredById;

    /**
     * @param $city_id
     */
    public function cityId( $city_id ): void
    {
        $this->builder->where( 'city_id', $city_id );
    }

    /**
     * @param $profile_id
     */
    public function profileId( $profile_id ): void
    {
        $this->builder->where( 'profile_id', $profile_id );
    }

    /**
     * @param string $district
     */
    public function district( string $district ): void
    {
        $this->builder->where( 'district', 'LIKE', "%$district%" );
    }

    /**
     * @param string $city_alias
     */
    public function cityAlias( string $city_alias ) : void
    {
        $this->builder->whereHas( 'city', function ( $query ) use ( $city_alias ) {
            $query->where( 'alias', $city_alias );
        } );
    }

    public function metro( int $metro_id ) : void
    {
        $this->builder->where( 'metro_id', $metro_id );
    }

    /**
     * @param string $alias
     */
    public function alias( string $alias ): void
    {
        $this->builder->where( 'alias', $alias );
    }

    /**
     * @param ...$ids
     * @return void
     */
    public function additionalService( ...$ids ) : void
    {
        $this->builder->whereRaw(
            '(' .
            '(' . DB::table( 'additional_services' )
                ->selectRaw( 'count(*)' )
                ->whereRaw( 'contacts.id = additional_services.contact_id' )
                ->whereIn( 'additional_services.as_id', $ids )->toSql() . ') = ' . count( $ids )

            . ' or ' .

            '(' . DB::table( 'profiles' )
                ->selectRaw( 'count(*)' )
                ->join( 'additional_services', 'profiles.id', '=', 'additional_services.profile_id' )
                ->whereRaw( 'contacts.profile_id = profiles.id' )
                ->whereIn( 'additional_services.as_id', $ids )->toSql() . ') = ' . count( $ids )
            . ')',

            [ ...$ids, ...$ids ]
        );
    }

    /**
     * @param $id
     * @return void
     */
    public function piercingPlace( $id ) : void
    {
        $this->builder->whereHas( 'specialization', function ( Builder $query ) use ( $id ) {
            $query->where( 'type', '&', \App\Enums\SpecializationTypes::PIERCING )
                ->whereJsonContains(
                    'attribute->' . 'c' .  \App\Enums\SpecializationTypes::PIERCING. '->' . 'd' . PiercingPlaceDictionary::TYPE, (int) $id );
        } );
    }

    /**
     * @param $id
     * @return void
     */
    public function tatuajePlace( $id ) : void
    {
        $this->builder->whereHas( 'specialization', function ( Builder $query ) use ( $id ) {
            $query->where( 'type', '&', \App\Enums\SpecializationTypes::TATUAJE )
                ->whereJsonContains(
                    'attribute->' . 'c' .  \App\Enums\SpecializationTypes::TATUAJE. '->' . 'd' . TatuajePlaceDictionary::TYPE, (int) $id );
        } );
    }

    public function mostFilled(): void
    {
        $this->builder->orderByRaw( 'filled_percent + additional_filled_percent DESC' );
    }
}
