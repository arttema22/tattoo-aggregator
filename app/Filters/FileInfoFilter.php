<?php

namespace App\Filters;

use App\Enums\SpecializationTypes;
use App\Models\Album;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingHealingPeriodDictionary;
use App\Models\Dictionaries\PiercingPainLevelDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use Illuminate\Database\Eloquent\Builder;

class FileInfoFilter extends QueryFilter
{
    /**
     * @param int $type
     */
    public function type( int $type ) : void
    {
        $this->builder->whereRaw( 'JSON_CONTAINS_PATH( `attribute`, "one", "$.c' . $type . '")' );
    }

    /**
     * @param string $text
     */
    public function searchText( string $text ) : void
    {
        $this->builder->where( function( Builder $query ) use ( $text ) {
            $query->where( 'name', 'LIKE', "%$text%" )
                  ->orWhere( 'description', 'LIKE', "%$text%" );
        } );
    }

    /**
     * @param $ids
     * @return void
     */
    public function gender( ...$ids ) : void
    {
        $this->builder->where( function( Builder $query ) use ( $ids ) {
            $query->whereJsonContains(
                'attribute->' . 'c' .  SpecializationTypes::PIERCING . '->' . 'd' . GenderDictionary::TYPE,
                (int) $ids[0] )
            ->orWhereJsonContains(
                'attribute->' . 'c' .  SpecializationTypes::TATTOO . '->' . 'd' . GenderDictionary::TYPE,
                (int) $ids[0] );

            unset( $ids[0] );
            foreach ( $ids as $id ) {
                $query->orWhereJsonContains(
                    'attribute->' . 'c' .  SpecializationTypes::PIERCING . '->' . 'd' . GenderDictionary::TYPE,
                    (int) $id )
                ->orWhereJsonContains(
                    'attribute->' . 'c' .  SpecializationTypes::TATTOO . '->' . 'd' . GenderDictionary::TYPE,
                    (int) $id );
            }
        } );
    }

    /**
     * @param $ids
     * @param int $specialization_type
     * @param int $dictionary_type
     */
    private function addSpecializationDictionaryFilter( $ids, int $specialization_type, int $dictionary_type ): void
    {
        $this->builder->where( function( Builder $query ) use ( $ids, $specialization_type, $dictionary_type ) {
            $query->whereJsonContains(
                'attribute->' . 'c' .  $specialization_type . '->' . 'd' . $dictionary_type,
                (int) $ids[0] );

            unset( $ids[0] );
            foreach ( $ids as $id ) {
                $query->orWhereJsonContains(
                    'attribute->' . 'c' .  $specialization_type . '->' . 'd' . $dictionary_type,
                    (int) $id );
            }
        } );
    }

    /**
     * @param $ids
     * @return void
     */
    public function tattooPlace( ...$ids ) : void
    {
        $this->addSpecializationDictionaryFilter( $ids, SpecializationTypes::TATTOO, TattooPlaceDictionary::TYPE );
    }

    /**
     * @param $ids
     * @return void
     */
    public function tattooSize( ...$ids ) : void
    {
        $this->addSpecializationDictionaryFilter( $ids, SpecializationTypes::TATTOO, TattooSizeDictionary::TYPE );
    }

    /**
     * @param $ids
     * @return void
     */
    public function tattooStyle( ...$ids ) : void
    {
        $this->addSpecializationDictionaryFilter( $ids, SpecializationTypes::TATTOO, TattooStyleDictionary::TYPE );
    }

    /**
     * @param $ids
     * @return void
     */
    public function tattooTempType( ...$ids ) : void
    {
        $this->addSpecializationDictionaryFilter( $ids, SpecializationTypes::TATTOO, TattooTempTypeDictionary::TYPE );
    }

    /**
     * @param $ids
     * @return void
     */
    public function piercingPlace( ...$ids ) : void
    {
        $this->addSpecializationDictionaryFilter( $ids, SpecializationTypes::PIERCING, PiercingPlaceDictionary::TYPE );
    }

    /**
     * @param int|null $min
     * @param int|null $max
     * @return void
     */
    public function piercingHealingPeriod( ?int $min, ?int $max ) : void
    {
        $this->builder->where( function( Builder $query ) use ( $min, $max ) {
            $attribute_path = '$.c' . SpecializationTypes::PIERCING . '.d' . PiercingHealingPeriodDictionary::TYPE;

            $query
                ->when( $min, function ( Builder $q ) use ( $attribute_path, $min ) {
                    $q->whereRaw(
                        'JSON_EXTRACT( `attribute`, "' . $attribute_path . '[0]") >= ' . $min );
                } )
                ->when( $max, function ( Builder $q ) use ( $attribute_path, $max ) {
                    $q->whereRaw(
                        'JSON_EXTRACT( `attribute`, "' . $attribute_path . '[1]") <= ' . $max );
                } );
        } );
    }

    /**
     * @param int|null $min
     * @param int|null $max
     * @return void
     */
    public function piercingPainLevel( ?int $min, ?int $max ) : void
    {
        $this->builder->where( function( Builder $query ) use ( $min, $max ) {
            $attribute_path = '$.c' . SpecializationTypes::PIERCING . '.d' . PiercingPainLevelDictionary::TYPE;

            $query
                ->when( $min, function ( Builder $q ) use ( $attribute_path, $min ) {
                    $q->whereRaw(
                        'JSON_EXTRACT( `attribute`, "' . $attribute_path . '") >= ' . $min );
                } )
                ->when( $max, function ( Builder $q ) use ( $attribute_path, $max ) {
                    $q->whereRaw(
                        'JSON_EXTRACT( `attribute`, "' . $attribute_path . '") <= ' . $max );
                } );
        } );
    }

    /**
     * @param $ids
     * @return void
     */
    public function tatuajePlace( ...$ids ) : void
    {
        $this->addSpecializationDictionaryFilter( $ids, SpecializationTypes::TATUAJE, TatuajePlaceDictionary::TYPE );
    }

    /**
     * @param int $is_approved
     * @return void
     */
    public function isApproved( int $is_approved ): void
    {
        $this->builder->where( 'is_approved', '=', $is_approved );
    }

    public function city( string $city_alias ) : void
    {
        $this->builder
            ->join( 'files', function ( $join ) {
                $join->on( 'files.id', '=', 'file_info.file_id' )
                     ->where( 'files.fileable_type', '=', Album::class );
            } )
            ->join( 'albums', 'albums.id', '=', 'files.fileable_id' )
            ->join( 'contacts', 'contacts.id', '=', 'albums.contact_id' )
            ->join( 'cities', 'cities.id', '=', 'contacts.city_id' )
            ->where( 'cities.alias', $city_alias );
    }

    /**
     * @param int $count
     */
    public function limit( int $count ): void
    {
        $this->builder->limit( $count );
    }

    /**
     * @param int $value
     */
    public function offset( int $value ): void
    {
        $this->builder->offset( $value );
    }
}
