<?php

namespace App\Console\Commands;

use App\DTO\AdditionalService\AdditionalServiceDTO;
use App\DTO\Album\AlbumDTO;
use App\DTO\Contact\ContactDTO;
use App\DTO\File\FileDTO;
use App\DTO\Profile\ProfileDTO;
use App\DTO\Service\ServiceDTO;
use App\DTO\SocialNetwork\SocialNetworkDTO;
use App\DTO\User\UserDTO;
use App\DTO\WorkingHours\WorkingHoursDTO;
use App\Enums\FileSubtypes;
use App\Enums\ProfileTypes;
use App\Enums\ServiceStatuses;
use App\Enums\SocialNetworkStatuses;
use App\Enums\SpecializationTypes;
use App\Filters\AdditionalServiceNameFilter;
use App\Filters\UserFilter;
use App\Models\AggSpecialization;
use App\Models\City;
use App\Models\Contact;
use App\Models\Metro;
use App\Models\Profile;
use App\Models\SocialNetworkName;
use App\Models\User;
use App\Services\AdditionalServiceNameService;
use App\Services\AdditionalServiceService;
use App\Services\AlbumService;
use App\Services\CityService;
use App\Services\ContactService;
use App\Services\FileService;
use App\Services\ProfileService;
use App\Services\ServiceService;
use App\Services\SocialNetworkService;
use App\Services\UserService;
use App\Services\WorkingHoursService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FillDBFrom2GIS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:2gis-db {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill database with data from csv-file (2gis)';

    // константы описывающие номера полей в файле
    private const ID       = 0;
    private const ID_GROUP = 1;

    private const PROFILE_NAME        = 4;
    private const PROFILE_EMAIL       = 28;
    private const PROFILE_DESCRIPTION = 34;

    private const CONTACT_CITY_MIN    = 12;
    private const CONTACT_CITY        = 14;
    private const CONTACT_DISTINCT_1  = 15;
    private const CONTACT_DISTINCT_2  = 16;
    private const CONTACT_ADDRESS     = 17;
    private const CONTACT_PHONE_1     = 18;
    private const CONTACT_PHONE_2     = 19;
    private const CONTACT_SITE        = 20;
    private const CONTACT_LAT         = 29;
    private const CONTACT_LON         = 30;
    private const CONTACT_LOGO        = 35;
    private const CONTACT_METRO       = 36;

    private const CONTACT_WH          = 32;

    private const SN_FACEBOOK  = 21;
    private const SN_INSTAGRAM = 22;
    private const SN_TWITTER   = 23;
    private const SN_VK        = 24;
    private const SN_YOUTUBE   = 25;
    private const SN_GOOGLE    = 26;
    private const SN_OK        = 27;

    private const AD_SERVICES = 31;

    private const CHECK_TITLE      = 5;
    private const CHECK_CATEGORIES = 9;
    private const CHECK_ATTRIBUTES = 33;

    // количество полей, которое должно быть в файле
    private const FILE_FIELDS_COUNT = 40;

    // количество полей, которое должно быть в файле
    private const DEFAULT_USER_PASSWORD = 'n#4jgV[DNr-4J!Q*';


    private UserService $user_service;

    private ProfileService $profile_service;

    private ContactService $contact_service;

    private CityService $city_service;

    private ServiceService $service_service;

    private AdditionalServiceService $as_service;

    private AdditionalServiceNameService $as_name_service;

    private SocialNetworkService $sn_service;

    private WorkingHoursService $wh_service;

    private AlbumService $album_service;

    private FileService $file_service;

    /**
     * FillDBFrom2GIS constructor.
     * @param UserService $user_service
     * @param ProfileService $profile_service
     * @param ContactService $contact_service
     * @param CityService $city_service
     * @param ServiceService $service_service
     * @param AdditionalServiceService $as_service
     * @param AdditionalServiceNameService $as_name_service
     * @param SocialNetworkService $sn_service
     * @param WorkingHoursService $wh_service
     * @param AlbumService $album_service
     * @param FileService $file_service
     */
    public function __construct(
        UserService $user_service,
        ProfileService $profile_service,
        ContactService $contact_service,
        CityService $city_service,
        ServiceService $service_service,
        AdditionalServiceService $as_service,
        AdditionalServiceNameService $as_name_service,
        SocialNetworkService $sn_service,
        WorkingHoursService $wh_service,
        AlbumService $album_service,
        FileService $file_service)
    {
        $this->user_service = $user_service;
        $this->profile_service = $profile_service;
        $this->contact_service = $contact_service;
        $this->city_service = $city_service;
        $this->service_service = $service_service;
        $this->as_service = $as_service;
        $this->as_name_service = $as_name_service;
        $this->sn_service = $sn_service;
        $this->wh_service = $wh_service;
        $this->album_service = $album_service;
        $this->file_service = $file_service;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        \Cache::clear();

        $file = $this->argument('file');
        if ( file_exists( $file ) === false ) {
            $this->error( 'File doesn\'t exists' );
            return 1;
        }

        $file_lines = file( $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

        // простая проверка файла на количество столбцов в csv
        if ( count( explode( ';', $file_lines[0] ) ) !== self::FILE_FIELDS_COUNT ) {
            $this->error( 'File incorrect [wrong fields count]' );
            return 2;
        }

        $cities = $this->city_service->getAll();
        foreach ( $cities as $city ) {
            $city->nameRu = $city->name['ru'];
            foreach ( $city->metro as $metro ) {
                $metro->nameRu = $metro->name['ru'];
            }
        }

        $as_names = $this->as_name_service->search( new AdditionalServiceNameFilter() );
        $sn_names = SocialNetworkName::all();

        // первая строка с заголовками
        unset( $file_lines[0] );

        foreach ( $file_lines as $line ) {
            $line_fields = str_getcsv( iconv( 'cp1251', 'utf-8', $line ), ';' );

            if ( $this->isRecordDataValid( $line_fields ) === false ) {
                continue;
            }

            $services = $this->getServices( $line_fields );
            if ( !$services ) {
                // если не найдено никаких услуг, то данный салон не подходит
                continue;
            }

            $city = $this->getCity( $cities, $line_fields[self::CONTACT_CITY] );
            if ( $city === null ) {
                continue;
            }

            $user = $this->parseUserData( $line_fields );
            if ( $user === null ) {
                continue;
            }

            $profile = $this->parseProfileData( $line_fields, $user );
            if ( $profile === null ) {
                continue;
            }

            $metro = $this->getMetro( $city, $line_fields[self::CONTACT_METRO] );

            $contact = $this->parseContactData( $line_fields, $profile, $city, $metro );
            if ( $contact === null ) {
                continue;
            }

            $this->parseAdditionalServices( $as_names, $contact, $line_fields[self::AD_SERVICES] );
            $this->parseSocialNetworks( $sn_names, $contact, $line_fields );
            $this->parseWorkingHours( $contact, $line_fields[self::CONTACT_WH] );
            $this->addServices( $contact, $services );
            $this->addAggSpecializations( $contact, $services );
            $this->addAlbums( $contact, $services );
            $this->addLogo( $user, $profile, $line_fields[self::CONTACT_LOGO] );
        }

        return 0;
    }

    /**
     * @param array $record
     * @return bool
     */
    private function isRecordDataValid( array $record ): bool
    {
        return
            trim( $record[self::CONTACT_LAT] ) !== '' &&
            trim( $record[self::CONTACT_LON] ) !== '';
    }

    /**
     * @param array $record
     * @return array
     */
    private function getServices( array $record ): array
    {
        $output = [];

        $name       = $record[self::PROFILE_NAME];
        $title      = $record[self::CHECK_TITLE];
        $categories = $record[self::CHECK_CATEGORIES];
        $services   = $record[self::CHECK_ATTRIBUTES];

        if ( stripos( $name, 'tattoo' ) !== false ||
            mb_stripos( $name, 'тату' ) !== false ||
            mb_stripos( $title, 'тату' ) !== false ||
            $categories === 'Тату-салоны' )
        {
            $output[] = SpecializationTypes::TATTOO;
        }

        if ( stripos( $name, 'piercing' ) !== false ||
            mb_stripos( $name, 'пирсинг' ) !== false ||
            mb_stripos( $title, 'пирсинг' ) !== false ||
            mb_stripos( $categories, 'украшения для пирсинга' ) !== false ||
            mb_stripos( $services, 'Пирсинг' ) !== false )
        {
            $output[] = SpecializationTypes::PIERCING;
        }

        if ( mb_stripos( $name, 'перманент' ) !== false ||
            mb_stripos( $services, 'Перманентный макияж' ) !== false )
        {
            $output[] = SpecializationTypes::TATUAJE;
        }

        return $output;
    }

    /**
     * @param Contact $contact
     * @param array $services
     */
    private function addServices( Contact $contact, array $services ): void
    {
        static $dictionary = [
            SpecializationTypes::TATTOO   => 'Татуировки',
            SpecializationTypes::TATUAJE  => 'Перманентный макияж',
            SpecializationTypes::PIERCING => 'Пирсинг'
        ];

        foreach ( $services as $service ) {
            $dto = new ServiceDTO();
            $dto->profile_id     = $contact->profile_id;
            $dto->contact_id     = $contact->id;
            $dto->name           = $dictionary[ $service ] ?? '-';
            $dto->type           = $service;
            $dto->price          = 0;
            $dto->currency       = 'RUB';
            $dto->is_start_price = false;
            $dto->status         = ServiceStatuses::ON;

            $this->service_service->create( $dto, $contact );
        }
    }

    /**
     * @param Contact $contact
     * @param array $services
     */
    private function addAggSpecializations( Contact $contact, array $services ): void
    {
        $type = 0;
        $attribute = [];
        foreach ( $services as $service ) {
            $type |= $service;
            $attribute[ 'c' . $service ] = [];
        }

        AggSpecialization::factory()
            ->state( [
                'type' => $type,
                'attribute' => $attribute
            ] )
            ->contact( $contact )
            ->create();
    }

    /**
     * @param Contact $contact
     * @param array $services
     */
    private function addAlbums( Contact $contact, array $services ): void
    {
        static $dictionary = [
            SpecializationTypes::TATTOO   => 'Татуировки',
            SpecializationTypes::TATUAJE  => 'Перманентный макияж',
            SpecializationTypes::PIERCING => 'Пирсинг'
        ];

        foreach ( $services as $service ) {
            $dto = new AlbumDTO();
            $dto->contact_id  = $contact->id;
            $dto->type        = $service;
            $dto->name        = $dictionary[ $service ] ?? '-';
            $dto->description = $dictionary[ $service ] ?? '-';

            $this->album_service->create( $dto, $contact );
        }
    }

    /**
     * @param User $user
     * @param Profile $profile
     * @param string $logo_url
     */
    private function addLogo( User $user, Profile $profile, string $logo_url ): void
    {
        if ( $logo_url === '' ) {
            return;
        }

        $response =
            Http::withHeaders( [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ] )->get( $logo_url );

        if ( $response->status() === 200 ) {
            $filename = md5( $response->body() );
            $filepath_original = Storage::path( config( 'image.original.path' ) ) . $filename;
            file_put_contents( $filepath_original, $response->body() );

            $image = Image::make( $filepath_original );

            $dto = new FileDTO();
            $dto->original         = $filename;
            $dto->fileable_subtype = FileSubtypes::PROFILE_AVATAR;
            $dto->size             = $image->filesize();
            $dto->mime_type        = $image->mime();
            $dto->user_id          = $user->id;

            $this->file_service->create( $dto, $profile );
        }
    }

    /**
     * @param array $record
     * @return User|null
     */
    private function parseUserData( array $record ): ?User
    {
        $email = $record[self::PROFILE_EMAIL] !== ''
            ? $record[self::PROFILE_EMAIL]
            : ( trim( str_replace( '\'', '', $record[self::ID_GROUP] ) ) . '@tattoo.test' );

        $filter = new UserFilter();
        $filter->setCustomFields( [ 'email' => $email ] );
        $users = $this->user_service->search( $filter );
        if ( !$users->isEmpty() ) {
            return $users->first();
        }

        $dto = new UserDTO();
        $dto->name     = $record[self::PROFILE_NAME];
        $dto->email    = $email;
        $dto->role     = config( 'roles.seller' );
        $dto->password = self::DEFAULT_USER_PASSWORD;

        return $this->user_service->create( $dto );
    }

    /**
     * @param array $record
     * @param User $user
     * @return Profile|null
     */
    private function parseProfileData( array $record, User $user ): ?Profile
    {
        $dto = new ProfileDTO();
        $dto->user_id     = $user->id;
        $dto->name        = $user->name;
        $dto->description = $record[self::PROFILE_DESCRIPTION];
        $dto->type        = ProfileTypes::SALON;

        return $this->profile_service->create( $dto, $user );
    }

    /**
     * @param array $record
     * @param Profile $profile
     * @param City $city
     * @param Metro|null $metro
     * @return Contact|null
     */
    private function parseContactData( array $record, Profile $profile, City $city, ?Metro $metro ): ?Contact
    {
        $dto = new ContactDTO();
        $dto->profile_id = $profile->id;
        $dto->name       = $profile->name;
        $dto->alias      = trim( str_replace( '\'', '', $record[self::ID] ) );
        $dto->city_id    = $city->id;
        $dto->country_id = $city->country_id;
        $dto->address    = $record[self::CONTACT_ADDRESS];
        $dto->phone      = $this->parsePhones( $record );
        $dto->site       = $record[self::CONTACT_SITE];
        $dto->email      = $record[self::PROFILE_EMAIL];
        $dto->district   = $record[self::CONTACT_DISTINCT_2] !== ''
            ? $record[self::CONTACT_DISTINCT_2]
            : $record[self::CONTACT_DISTINCT_1];
        $dto->lat        = $record[self::CONTACT_LAT];
        $dto->lon        = $record[self::CONTACT_LON];

        if ( $metro !== null ) {
            $dto->metro_id = $metro->id;
        }

        return $this->contact_service->create( $dto, $profile );
    }

    /**
     * @param Collection $cities
     * @param string $record_city
     * @return City|null
     */
    private function getCity(Collection $cities, string $record_city ): ?City
    {
        return $cities->where( 'nameRu', $record_city )->first();
    }

    /**
     * @param City $city
     * @param string $record_metro
     * @return Metro|null
     */
    private function getMetro(City $city, string $record_metro ): ?Metro
    {
        return $city->metro->where( 'nameRu', $record_metro )->first();
    }

    /**
     * @param Collection $as_names
     * @param Contact $contact
     * @param string $record_additional_services
     * @return void
     */
    private function parseAdditionalServices(
        Collection $as_names,
        Contact $contact,
        string $record_additional_services ): void
    {
        if ( mb_stripos( $record_additional_services, 'Перевод с карты' ) !== false ) {
            $as_name = $as_names->firstWhere( 'name', 'Оплата переводом на карту' );
            if ( $as_name !== null ) {
                $dto = new AdditionalServiceDTO();
                $dto->as_id = $as_name->id;
                $dto->contact_id = $contact->id;
                $this->as_service->create( $dto, $contact );
            }
        }

        if ( mb_stripos( $record_additional_services, 'Оплата картой' ) !== false ||
             mb_stripos( $record_additional_services, 'Оплата через банк' ) !== false ||
             mb_stripos( $record_additional_services, 'Оплата эл. кошельком' ) !== false )
        {
            $as_name = $as_names->firstWhere( 'name', 'Оплата банковской картой' );
            if ( $as_name !== null ) {
                $dto = new AdditionalServiceDTO();
                $dto->as_id = $as_name->id;
                $dto->contact_id = $contact->id;
                $this->as_service->create( $dto, $contact );
            }
        }
    }

    /**
     * @param Collection $sn_names
     * @param Contact $contact
     * @param array $record
     * @return void
     */
    private function parseSocialNetworks(
        Collection $sn_names,
        Contact $contact,
        array $record ): void
    {
        $twitter = trim( $record[self::SN_TWITTER] );
        if ( $twitter !== '' && preg_match( '/^https:\/\/twitter\.com\/(.+?)$/', $twitter, $match ) ) {
            $sn_name = $sn_names->firstWhere( 'name', 'Twitter' );
            if ( $sn_name !== null ) {
                $dto = new SocialNetworkDTO();
                $dto->sn_id      = $sn_name->id;
                $dto->value      = $match[1];
                $dto->status     = SocialNetworkStatuses::ENABLED;

                $this->sn_service->create( $dto, $contact );
            }
        }

        $vk = trim( $record[self::SN_VK] );
        if ( $vk !== '' && preg_match( '/^https:\/\/vk\.com\/(.+?)$/', $vk, $match ) ) {
            $sn_name = $sn_names->firstWhere( 'name', 'VK' );
            if ( $sn_name !== null ) {
                $dto = new SocialNetworkDTO();
                $dto->sn_id      = $sn_name->id;
                $dto->value      = $match[1];
                $dto->status     = SocialNetworkStatuses::ENABLED;

                $this->sn_service->create( $dto, $contact );
            }
        }
    }

    /**
     * @param Contact $contact
     * @param string $working_hours
     */
    private function parseWorkingHours( Contact $contact, string $working_hours ): void
    {
        static $dictionary = [
            'Пн' => 1,
            'Вт' => 2,
            'Ср' => 3,
            'Чт' => 4,
            'Пт' => 5,
            'Сб' => 6,
            'Вс' => 7,
        ];

        $wh_dto_list = [];
        if ( $working_hours !== '' ) {
            $working_hours_list = explode( ',', $working_hours );
            foreach ( $working_hours_list as $tmp ) {
                if ( preg_match( '/(Пн|Вт|Ср|Чт|Пт|Сб|Вс):(\d+):\d+-(\d+):\d+/ui', trim( $tmp ), $match ) ) {
                    $dto = new WorkingHoursDTO();
                    $dto->day = $dictionary[ $match[1] ];
                    if ( (int)$match[2] === 0 && (int)$match[3] === 24 ) {
                        $dto->is_nonstop = true;
                    } else {
                        $dto->start = $match[2];
                        $dto->end = $match[3];
                    }

                    $wh_dto_list[ $dictionary[ $match[1] ] ] = $dto;
                }
            }
        }

        foreach ( $dictionary as $day ) {
            if ( !isset( $wh_dto_list[ $day ] ) ) {
                $dto = new WorkingHoursDTO();
                $dto->day = $day;
                $dto->is_weekend = true;
                $wh_dto_list[ $day ] = $dto;
            }
        }

        foreach ( $wh_dto_list as $wh_dto ) {
            $this->wh_service->create( $wh_dto, $contact );
        }
    }

    /**
     * @param array $record
     * @return string
     */
    private function parsePhones( array $record ): string
    {
        // парсинг телефонов
        $field_phone_1 = trim( $record[self::CONTACT_PHONE_1] );
        $field_phone_2 = trim( $record[self::CONTACT_PHONE_2] );
        $phones_mobile =
            $field_phone_1 !== ''
                ? explode( ',', $field_phone_1 )
                : [];
        $phones_static =
            $field_phone_2 !== ''
                ? explode( ',', $field_phone_2 )
                : [];

        return implode( "\n", array_map( 'trim', array_merge( $phones_mobile, $phones_static ) ) );
    }
}
