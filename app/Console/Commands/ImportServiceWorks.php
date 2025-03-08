<?php

namespace App\Console\Commands;

use App\DTO\File\FileDTO;
use App\DTO\FileInfo\FileInfoDTO;
use App\Enums\FileSubtypes;
use App\Enums\SpecializationTypes;
use App\Enums\WorkApproved;
use App\Helpers\SpecialisationTypeHelper;
use App\Models\Album;
use App\Models\City;
use App\Models\Contact;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingHealingPeriodDictionary;
use App\Models\Dictionaries\PiercingPainLevelDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use App\Models\File;
use App\Models\User;
use App\Services\FileInfoService;
use App\Services\FileService;
use Exception;
use Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImportServiceWorks extends Command
{
    /**
     * @var string
     */
    protected $signature = 'import:works-db {service-type} {file} {images-directory}';

    /**
     * @var string
     */
    protected $description = 'Import service works images';

    private const TATTOO_FILE_NAME   = 0;
    private const TATTOO_GENDER      = 1;
    private const TATTOO_PLACE       = 2;
    private const TATTOO_SIZE        = 3;
    private const TATTOO_STYLE       = 4;
    private const TATTOO_TEMP_TYPE   = 5;
    private const TATTOO_NAME        = 6;
    private const TATTOO_DESCRIPTION = 7;

    private const TATUAJE_FILE_NAME   = 0;
    private const TATUAJE_PLACE       = 1;
    private const TATUAJE_NAME        = 2;
    private const TATUAJE_DESCRIPTION = 3;

    private const PIERCING_FILE_NAME      = 0;
    private const PIERCING_GENDER         = 1;
    private const PIERCING_PLACE          = 2;
    private const PIERCING_HEALING_PERIOD = 3;
    private const PIERCING_PAIN_LEVEL     = 4;
    private const PIERCING_NAME           = 5;
    private const PIERCING_DESCRIPTION    = 6;

    // минимальное численность населения для города, в салоны которых будут добавлены работы
    private const MIN_CITY_POPULATION = 1000000;

    private FileInfoService $file_info_service;

    private FileService $file_service;

    /**
     * ImportServiceWorks constructor.
     * @param FileInfoService $file_info_service
     * @param FileService $file_service
     */
    public function __construct( FileInfoService $file_info_service, FileService $file_service )
    {
        $this->file_info_service = $file_info_service;
        $this->file_service = $file_service;

        parent::__construct();
    }

    /**
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        $file = $this->argument('file');
        if ( file_exists( $file ) === false ) {
            $this->error( 'File doesn\'t exists' );
            return 1;
        }

        $specialisation_type =
            SpecialisationTypeHelper::getTypeFromName(
                $this->argument( 'service-type' ) );
        if ( !in_array(
            $specialisation_type,
            [
                SpecializationTypes::TATTOO,
                SpecializationTypes::TATUAJE,
                SpecializationTypes::PIERCING
            ],
            true ) )
        {
            $this->error( 'Undefined service_type' );
            return 2;
        }

        $images_directory = $this->argument('images-directory');
        if ( is_dir( $images_directory ) === false ) {
            $this->error( 'Images directory doesn\'t exists' );
            return 3;
        }

        $images_collection = $this->parseFile( $file, $specialisation_type );
        if ( $images_collection->isEmpty() ) {
            $this->error( 'Parsed data is empty' );
            return 4;
        }

        $cities_map = $this->getCitiesMap( $images_collection->count(), $specialisation_type );
        $this->imagesToBase( $images_collection, $images_directory, $specialisation_type, $cities_map );

        return 0;
    }

    /**
     * @param string $file
     * @param int $service_type
     * @return Collection
     */
    private function parseFile( string $file, int $service_type ): Collection
    {
        $data = file( $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

        shuffle( $data );

        // первая строка с заголовками
        unset( $data[0] );

        switch ( $service_type ) {
            case SpecializationTypes::TATTOO:
                return $this->parseTattooData( $data );

            case SpecializationTypes::TATUAJE:
                return $this->parceTatuajeData( $data );

            case SpecializationTypes::PIERCING:
                return $this->parsePiercingData( $data );
        }

        return collect();
    }

    /**
     * @param array $data
     * @return Collection
     */
    private function parseTattooData( array $data ): Collection
    {
        $genders      = GenderDictionary::all();
        $tattoo_place = TattooPlaceDictionary::all();
        $tattoo_size  = TattooSizeDictionary::all();
        $tattoo_style = TattooStyleDictionary::all();
        $tattoo_temp  = TattooTempTypeDictionary::all();

        $collection_array = [];
        foreach ( $data as $record ) {
            $fields = explode( ';', iconv( 'cp1251', 'utf-8', $record ) );
            $styles = array_map(
                static fn( $style ) => trim( $style ),
                array_unique(
                    explode( ',', $fields[ self::TATTOO_STYLE ] )
                )
            );

            $collection_array[] = [
                'file'        => $fields[ self::TATTOO_FILE_NAME ],
                'name'        => $fields[ self::TATTOO_NAME ] ?? '',
                'description' => $fields[ self::TATTOO_DESCRIPTION ] ?? '',
                'attributes'  => [
                    'c' . SpecializationTypes::TATTOO => [
                        'd' . GenderDictionary::TYPE         => $genders->where( 'name', $fields[ self::TATTOO_GENDER ] )->pluck( 'id' )->toArray(),
                        'd' . TattooPlaceDictionary::TYPE    => $tattoo_place->where( 'name', $fields[ self::TATTOO_PLACE ] )->pluck( 'id' )->toArray(),
                        'd' . TattooSizeDictionary::TYPE     => $tattoo_size->where( 'name', $fields[ self::TATTOO_SIZE ] )->pluck( 'id' )->toArray(),
                        'd' . TattooStyleDictionary::TYPE    => $tattoo_style->whereIn( 'name', $styles )->pluck( 'id' )->toArray(),
                        'd' . TattooTempTypeDictionary::TYPE => $tattoo_temp->where( 'name', $fields[ self::TATTOO_TEMP_TYPE ] )->pluck( 'id' )->toArray()
                    ]
                ]
            ];
        }

        return collect( $collection_array );
    }

    /**
     * @param array $data
     * @return Collection
     */
    private function parsePiercingData( array $data ): Collection
    {
        $genders        = GenderDictionary::all();
        $piercing_place = PiercingPlaceDictionary::all();

        $collection_array = [];
        foreach ( $data as $record ) {
            $fields = explode( ';', iconv( 'cp1251', 'utf-8', $record ) );

            $collection_array[] = [
                'file'        => $fields[ self::PIERCING_FILE_NAME ],
                'name'        => $fields[ self::PIERCING_NAME ] ?? '',
                'description' => $fields[ self::PIERCING_DESCRIPTION ] ?? '',
                'attributes'  => [
                    'c' . SpecializationTypes::PIERCING => [
                        'd' . GenderDictionary::TYPE                => $genders->where( 'name', $fields[ self::PIERCING_GENDER ] )->pluck( 'id' )->toArray(),
                        'd' . PiercingPlaceDictionary::TYPE         => $piercing_place->where( 'name', $fields[ self::PIERCING_PLACE ] )->pluck( 'id' )->toArray(),
                        'd' . PiercingHealingPeriodDictionary::TYPE => $fields[ self::PIERCING_HEALING_PERIOD ] !== '' ? array_map( 'trim', explode( '-', $fields[ self::PIERCING_HEALING_PERIOD ], 2 ) ) : null,
                        'd' . PiercingPainLevelDictionary::TYPE     => $fields[ self::PIERCING_PAIN_LEVEL ] !== '' ? $fields[ self::PIERCING_PAIN_LEVEL ] : null,
                    ]
                ]
            ];
        }

        return collect( $collection_array );
    }

    /**
     * @param array $data
     * @return Collection
     */
    private function parceTatuajeData( array $data ): Collection
    {
        $tatuaje_place = TatuajePlaceDictionary::all();

        $collection_array = [];
        foreach ( $data as $record ) {
            $fields = explode( ';', iconv( 'cp1251', 'utf-8', $record ) );

            $collection_array[] = [
                'file'        => $fields[ self::TATUAJE_FILE_NAME ],
                'name'        => $fields[ self::TATUAJE_NAME ] ?? '',
                'description' => $fields[ self::TATUAJE_DESCRIPTION ] ?? '',
                'attributes'  => [
                    'c' . SpecializationTypes::TATUAJE => [
                        'd' . TatuajePlaceDictionary::TYPE => $tatuaje_place->where( 'name', $fields[ self::TATUAJE_PLACE ] )->pluck( 'id' )->toArray(),
                    ]
                ]
            ];
        }

        return collect( $collection_array );
    }

    /**
     * @param string $original_file_path
     * @return string
     */
    private function saveFile( string $original_file_path ): string
    {
        if ( file_exists( $original_file_path ) === false ) {
            return '';
        }

        $filename = md5_file( $original_file_path );
        $extension = pathinfo( $original_file_path, PATHINFO_EXTENSION );

        $storage_file_path = Storage::path( config( 'image.original.path' ) ) . $filename . '.' . $extension;
        if ( @copy( $original_file_path, $storage_file_path ) === false ) {
            return '';
        }

        return $storage_file_path;
    }

    /**
     * @param User $user
     * @param Album $album
     * @param string $file_path
     * @param string $original_filename
     * @return File|null
     */
    private function addFile(
        User $user,
        Album $album,
        string $file_path,
        string $original_filename ): ?File
    {
        $image = Image::make( $file_path );

        $dto = new FileDTO();
        $dto->original         = $original_filename;
        $dto->fileable_subtype = FileSubtypes::COMMON;
        $dto->size             = $image->filesize();
        $dto->mime_type        = $image->mime();
        $dto->user_id          = $user->id;

        return $this->file_service->create( $dto, $album );
    }

    /**
     * @param File $file
     * @param string $name
     * @param string $description
     * @param array $attributes
     */
    private function addFileInfo( File $file, string $name, string $description, array $attributes ): void
    {
        $dto = new FileInfoDTO();
        $dto->name            = $name;
        $dto->description     = $description;
        $dto->attribute       = $attributes;
        $dto->is_approved     = WorkApproved::APPROVE;
        $dto->is_adult        = false;
        $dto->is_downloadable = false;

        $this->file_info_service->create( $dto, $file );
    }

    /**
     * @param int $images_count
     * @param int $service_type
     * @return array
     * @throws Exception
     */
    protected function getCitiesMap( int $images_count, int $service_type ) : array
    {
        $output = [];

        $cities =
            City::with( 'contacts.specialization' )
                ->where( 'country_id', '=', 1 )
                ->where( 'population', '>', self::MIN_CITY_POPULATION )
                ->get();

        $population_count = $cities->sum( fn( $city ) => $city->population );
        $salon_count      = $cities->sum( fn( $city ) => $city->contacts->filter( function ( $contact ) use ( $service_type ) {
            return $contact->specialization->type & $service_type;
        } )->count() );

        foreach ( $cities as $city ) {
            $salons = $city->contacts->filter( function ( $contact ) use ( $service_type ) {
                return $contact->specialization->type & $service_type;
            } )->count();
            if ( $salons === 0 ) {
                continue;
            }

            $population_percent = $city->population / $population_count * 100;
            $salon_percent      = $salons / $salon_count * 100;
            $current_percent    = $population_percent * ( $salon_percent > 1 ? 1.5 : $salon_percent );

            $images_to_city     = ceil( $images_count / 100 * $current_percent );
            $images_per_salon   = ceil( $images_to_city / $salons );
            $min                = floor( $images_per_salon / 1.5 );
            $max                = floor( $images_per_salon * 2.5 );

            $range = $this->getRange( $min, $max, $salons, $images_to_city );
            $output[] = [
                'city'  => $city->id,
                'range' => $range
            ];
        }

        return $output;
    }

    /**
     * @param int $min
     * @param int $max
     * @param int $count
     * @param int $all
     * @return array
     * @throws Exception
     */
    protected function getRange( int $min, int $max, int $count, int $all ) : array
    {
        $output = [];

        for ( $i = 0; $i < $count; $i++ ) {
            $c = random_int( $min, $max );
            if ( ( $all - $c ) < 0 ) {
                $c = $all;
            }

            $all -= $c;
            $output[] = $c;
        }

        return $output;
    }

    /**
     * @param Collection $images_data
     * @param string $images_directory
     * @param int $specialisation_type
     * @param array $cities_map
     */
    private function imagesToBase( Collection $images_data, string $images_directory, int $specialisation_type, array $cities_map ): void
    {
        /** @var User $user */
        $user = User::whereRole( 1 )->first();
        $gen_images = $this->getImages( $images_data );

        foreach ( $cities_map as [ 'city' => $city_id, 'range' => $range ] ) {
            $salons = Contact::with( [ 'albums' ] )
                ->where( 'city_id', '=', $city_id )
                ->whereHas( 'specialization', function ( $query ) use ( $specialisation_type ) {
                    $query->where( 'type', $specialisation_type );
                } )
                ->get();

            foreach ( $salons as $k => $salon ) {
                $count = $range[ $k ];

                for ( $i = 0; $i < $count; $i++ ) {
                    $image = $gen_images->current();
                    $gen_images->next();

                    // выходим, если больше нет изображений
                    if ( $image === null ) {
                        return;
                    }

                    $storage_file_path = $this->saveFile( $images_directory . '/' . $image['file'] );
                    if ( $storage_file_path !== '' ) {
                        $file = $this->addFile(
                            $user,
                            $salon->albums->firstWhere( 'type', $specialisation_type ),
                            $storage_file_path,
                            basename( $storage_file_path ) );

                        if ( $file !== null ) {
                            $this->addFileInfo( $file, $image['name'], $image['description'], $image['attributes'] );
                        }
                    }
                }
            }
        }
    }

    /**
     * @param Collection $images
     * @return Generator
     */
    protected function getImages( Collection $images ) : Generator
    {
        foreach ( $images as $image ) {
            yield $image;
        }
    }
}
