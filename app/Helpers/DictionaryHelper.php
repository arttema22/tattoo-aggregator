<?php

namespace App\Helpers;

use App\DTO\Dictionary\DictionaryDTO;
use App\Models\Dictionaries\ADictionary;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingHealingPeriodDictionary;
use App\Models\Dictionaries\PiercingPainLevelDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\ServiceOtherDictionary;
use App\Models\Dictionaries\ServicePiercingDictionary;
use App\Models\Dictionaries\ServiceTattooDictionary;
use App\Models\Dictionaries\ServiceTatuajeDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use \Psr\SimpleCache\InvalidArgumentException;

class DictionaryHelper
{
    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function gender( bool $asDTO = false ) : Collection
    {
        return self::get( GenderDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function piercingHealingPeriod( bool $asDTO = false ) : Collection
    {
        return self::get( PiercingHealingPeriodDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function piercingPainLevel( bool $asDTO = false ) : Collection
    {
        return self::get( PiercingPainLevelDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function piercingPlace( bool $asDTO = false ) : Collection
    {
        return self::get( PiercingPlaceDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function tattooPlace( bool $asDTO = false ) : Collection
    {
        return self::get( TattooPlaceDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function tattooSize( bool $asDTO = false ) : Collection
    {
        return self::get( TattooSizeDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function tattooStyle( bool $asDTO = false ) : Collection
    {
        return self::get( TattooStyleDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function tattooTempType( bool $asDTO = false ) : Collection
    {
        return self::get( TattooTempTypeDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function tatuajePlace( bool $asDTO = false ) : Collection
    {
        return self::get( TatuajePlaceDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function serviceTattoo( bool $asDTO = false ) : Collection
    {
        return self::get( ServiceTattooDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function serviceTatuaje( bool $asDTO = false ) : Collection
    {
        return self::get( ServiceTatuajeDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function servicePiercing( bool $asDTO = false ) : Collection
    {
        return self::get( ServicePiercingDictionary::class, $asDTO );
    }

    /**
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    public static function serviceOther( bool $asDTO = false ) : Collection
    {
        return self::get( ServiceOtherDictionary::class, $asDTO );
    }

    /**
     * @param string $dictionary
     * @param bool $asDTO
     * @return Collection
     * @throws InvalidArgumentException
     */
    protected static function get( string $dictionary, bool $asDTO = false ) : Collection
    {
        if ( $asDTO ) {
            return self::getDictionariesAsDTO( $dictionary );
        }

        /** @var ADictionary $dictionary */
        if ( Cache::has( $dictionary ) ) {
            return Cache::get( $dictionary );
        }

        $output = $dictionary::all()->pluck( 'name', 'id' );
        Cache::set( $dictionary, $output );

        return $output;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected static function getDictionariesAsDTO( string $dictionary ): Collection
    {
        $dictionary_cache_key = $dictionary . '-slug';

        /** @var ADictionary $dictionary */
        if ( Cache::has( $dictionary_cache_key ) ) {
            return Cache::get( $dictionary_cache_key );
        }

        $output = $dictionary::all()->mapWithKeys( function ( ADictionary $item ) {
            $dto = App::make( DictionaryDTO::class );
            $dto->id = $item->id;
            $dto->type = $item->type;
            $dto->name = $item->name;
            $dto->slug = $item->slug;

            return [
                $item->id => $dto
            ];
        });
        Cache::set( $dictionary_cache_key, $output );

        return $output;
    }

    public static function getNameByAttribute( Collection $dictionariesDTO, ?string $attribute ): string
    {
        return $dictionariesDTO[$attribute]?->name ?? '';
    }

    public static function getSelectedDictionaries(
        Collection $dictionariesDTO,
        array $selected,
        string $selected_filter = '' ): Collection
    {
        if ( $selected_filter !== '' ) {
            $selected[] = $selected_filter;
        }

        if ( $selected !== [] ) {
            return $dictionariesDTO->whereIn( 'slug', $selected )->keyBy( 'id' );
        }

        return collect();
    }

    public static function getDictionaryTypeBySlug( int $type, string $slug ): int|false
    {
        $dictionaries = SpecialisationDictionaryHelper::get( $type )[ SpecialisationTypeHelper::getTypeFromId( $type ) ] ?? [];
        foreach ( $dictionaries as $dictionary ) {
            if ( $dictionary['data']->search( fn ( DictionaryDTO $dictionaryDTO ) => $dictionaryDTO->slug === $slug ) !== false ) {
                return $dictionary['id'];
            }
        }

        return false;
    }

    public static function getDictionaryTypeById( int $type, int $id ): int|false
    {
        $dictionaries = SpecialisationDictionaryHelper::get( $type )[ SpecialisationTypeHelper::getTypeFromId( $type ) ] ?? [];
        foreach ( $dictionaries as $dictionary ) {
            if ( $dictionary['data']->search( fn ( DictionaryDTO $dictionaryDTO ) => $dictionaryDTO->id === $id ) !== false ) {
                return $dictionary['id'];
            }
        }

        return false;
    }

    public static function getDictionariesAsStringByAttributes( array $dictionaries, array $attributes ): string
    {
        $output = [];
        foreach( $dictionaries as $dictionary ) {
            $attribute = $attributes[ 'd' . $dictionary[ 'id' ] ][ 0 ] ?? null;
            if ( $attribute !== null && ( $dictionary[ 'data' ][ $attribute ] ?? null ) !== null ) {
                $output[] = mb_strtolower( self::getNameByAttribute( $dictionary[ 'data' ], $attribute ) );
            }
        }

        return implode(', ', $output);
    }

    public static function groupFilterSlugsByType( int $type, string $filter_slug ): array
    {
        $output = [];
        foreach ( explode( '_', $filter_slug ) as $slug ) {
            $filter_dictionary_type = self::getDictionaryTypeBySlug( $type, $slug );
            if ( $filter_dictionary_type !== false ) {
                $output[ $filter_dictionary_type ] = $slug;
            }
        }

        return $output;
    }

    public static function groupDictionaryIdsByType( int $type, array $dictionary_ids ): array
    {
        $output = [];
        foreach ( $dictionary_ids as $dictionary_id ) {
            $filter_dictionary_type = self::getDictionaryTypeById( $type, $dictionary_id );
            if ( $filter_dictionary_type !== false ) {
                $output[ $filter_dictionary_type ][] = $dictionary_id;
            }
        }

        return $output;
    }

    public static function getFilterNameFromDictionaryType( int $type ): string
    {
        $dictionary = [
            GenderDictionary::TYPE => 'gender',
            PiercingPlaceDictionary::TYPE => 'piercingPlace',
            TattooPlaceDictionary::TYPE => 'tattooPlace',
            TattooSizeDictionary::TYPE => 'tattooSize',
            TattooStyleDictionary::TYPE => 'tattooStyle',
            TattooTempTypeDictionary::TYPE => 'tattooTempType',
            TatuajePlaceDictionary::TYPE => 'tatuajePlace',
        ];

        return $dictionary[ $type ] ?? '';
    }

    public static function getFilterNameBySlug( array $dictionaries, string $filter_slug ): string
    {
        $names = [];
        foreach ( explode( '_', $filter_slug ) as $slug ) {
            foreach ( $dictionaries as $dictionary ) {
                $filter =
                    $dictionary['data']
                        ->filter( fn ( DictionaryDTO $dictionaryDTO ) => $dictionaryDTO->slug === $slug )
                        ->first();
                if ( $filter ) {
                    $names[] = mb_strtolower( $filter->name );
                }
            }
        }

        return implode( ' ', $names );
    }
}
