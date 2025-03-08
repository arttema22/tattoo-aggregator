<?php

namespace App\Orchid\Screens\Salon;

use App\DTO\AdditionalService\AdditionalServiceDTO;
use App\DTO\File\FileDTO;
use App\Enums\CurrencyTypes;
use App\Enums\ServiceStatuses;
use App\Enums\SocialNetworkStatuses;
use App\Events\UploadedImageEvent;
use App\Events\VideoAddEvent;
use App\Events\VideoReParseEvent;
use App\Helpers\DTOHelper;
use App\Http\Requests\Profile\UpdateAdditionalServicesRequest;
use App\Models\Contact;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Service;
use App\Models\SocialNetwork;
use App\Models\Video;
use App\Models\WorkingHours;
use App\Orchid\Extends\Screen\LayoutFactoryExt;
use App\Orchid\Layouts\Salon\AdditionalServiceEditLayout;
use App\Orchid\Layouts\Salon\ContactEditLayout;
use App\Orchid\Layouts\Salon\GalleryTableLayout;
use App\Orchid\Layouts\Salon\GeneralEditLayout;
use App\Orchid\Layouts\Salon\ReviewTableLayout;
use App\Orchid\Layouts\Salon\ServiceEditLayout;
use App\Orchid\Layouts\Salon\ServiceTableLayout;
use App\Orchid\Layouts\Salon\SiblingTableLayout;
use App\Orchid\Layouts\Salon\SocialEditLayout;
use App\Orchid\Layouts\Salon\SocialTableLayout;
use App\Orchid\Layouts\Salon\VideoEditLayout;
use App\Orchid\Layouts\Salon\VideoTableLayout;
use App\Orchid\Layouts\Salon\WorkingHourEditLayout;
use App\Orchid\Layouts\Salon\WorkingHourTableLayout;
use App\Services\AdditionalServiceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Models\File as Pic;

class SalonEditScreen extends Screen
{
    public ?Contact $salon;

    /**
     * @return array
     */
    public function query( Contact $salon ): iterable
    {
        $salon->load( [
            'profile.user',
            'services',
            'additionalServices',
            'videos',
            'socialNetworks.socialNetworkName',
            'workingHours',
            'reviews',
            'albums.files.fileInfo',
        ] );

        return [
            'salon' => $salon,
            'place' => [
                'lat' => $salon?->lat ?? 0.0,
                'lng' => $salon?->lon ?? 0.0,
            ],
        ];
    }

    /**
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Просмотр данных о салоне';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.salons',
        ];
    }

    /**
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make( 'Перейти в салон' )
                ->icon( 'link' )
                ->target( '_blank' )
                ->route( 'salon.index', [ 'alias' => $this->salon?->alias ?? '' ] ),

            Link::make( 'Назад' )
                ->icon( 'action-undo' )
                ->route( 'platform.salons' ),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs( [
                'Общее'            => LayoutFactoryExt::blockExt( GeneralEditLayout::class )
                    ->vertical()
                    ->commands(
                        Button::make( 'Сохранить' )
                            ->icon( 'save' )
                            ->type( Color::DEFAULT() )
                            ->method( 'updateGeneral', [
                                'contact_id' => $this->salon?->id ?? 0,
                            ] )
                    ),
                'Галерея'          => GalleryTableLayout::class,
                'Услуги'           => LayoutFactoryExt::blockExt( ServiceTableLayout::class )
                    ->vertical()
                    ->commands(
                        ModalToggle::make( __( 'Добавить' ) )
                            ->icon( 'plus' )
                            ->type( Color::DEFAULT() )
                            ->modal( 'asyncAddServiceModal' )
                            ->modalTitle( 'Добавить услугу' )
                            ->method( 'addService' )
                            ->asyncParameters( [
                                'profile_id' => $this->salon?->profile->id ?? 0,
                                'contact_id' => $this->salon?->id ?? 0,
                            ] )
                    ),
                'Доп. услуги'      => LayoutFactoryExt::blockExt( AdditionalServiceEditLayout::class )
                    ->vertical()
                    ->commands(
                        Button::make( 'Сохранить' )
                            ->icon( 'save' )
                            ->type( Color::DEFAULT() )
                            ->method( 'updateAdditionalService', [
                                'contact_id' => $this->salon?->id ?? 0,
                            ] )
                    ),
                'Видео'            => LayoutFactoryExt::blockExt( VideoTableLayout::class )
                    ->vertical()
                    ->commands(
                        ModalToggle::make( __( 'Добавить' ) )
                            ->icon( 'plus' )
                            ->type( Color::DEFAULT() )
                            ->modal( 'asyncAddVideoModal' )
                            ->modalTitle( 'Добавить видео' )
                            ->method( 'addVideo' )
                            ->asyncParameters( [
                                'profile_id' => $this->salon?->profile->id ?? 0,
                                'contact_id' => $this->salon?->id ?? 0,
                            ] )
                    ),
                'Соц. сети'        => LayoutFactoryExt::blockExt( SocialTableLayout::class )
                    ->vertical()
                    ->commands(
                        ModalToggle::make( __( 'Добавить' ) )
                            ->icon( 'plus' )
                            ->type( Color::DEFAULT() )
                            ->modal( 'asyncAddSocialModal' )
                            ->modalTitle( 'Добавить соц. сеть' )
                            ->method( 'addSocial' )
                            ->asyncParameters( [
                                'profile_id' => $this->salon?->profile->id ?? 0,
                                'contact_id' => $this->salon?->id ?? 0,
                            ] )
                    ),
                'Часы работы'      => WorkingHourTableLayout::class,
                'Контакты'         => LayoutFactoryExt::blockExt( ContactEditLayout::class )
                    ->vertical()
                    ->commands(
                        Button::make( 'Сохранить' )
                            ->icon( 'save' )
                            ->type( Color::DEFAULT() )
                            ->method( 'updateContact', [
                                'contact_id' => $this->salon?->id ?? 0,
                            ] )
                    ),
                'Отзывы'           => ReviewTableLayout::class,
                'Связанные салоны' => SiblingTableLayout::class,
                'Владелец'         => Layout::legend( 'salon.profile', [
                    Sight::make( 'user.name', 'Ник' ),
                    Sight::make( 'user.email', 'Email' ),
                    Sight::make( 'user.created_at', 'Дата создания аккаунта' )
                        ->render( function ( Profile $model ) {
                            return $model->user->created_at->format( 'Y-m-d H:i:s' );
                        } ),
                    Sight::make( 'user.email_verified_at', 'Когда подтвержден email' )
                        ->render( function ( Profile $model ) {
                            if ( $model->user->email_verified_at === null ) {
                                return 'n/a';
                            }

                            return $model->user->email_verified_at->format( 'Y-m-d H:i:s' );
                        } ),
                    Sight::make( 'approved', 'Аккаунт принадлежит владельцу' )
                        ->render( function ( Profile $model ) {
                            return $model->approved === 1
                                ? '<i class="fas fa-check text-success"></i>'
                                : '<i class="fas fa-times text-danger"></i>';
                        } ),
                    Sight::make( 'Действия' )->render( function ( Profile $model ) {
                        return Link::make( 'Перейти в профиль' )
                            ->icon( 'login' )
                            ->type( Color::DEFAULT() )
                            ->route( 'platform.systems.users.edit', [ 'user' => $model->user_id ] )
                            ->style( 'width: 190px' );
                    } )
                ] ),
            ] ),

            Layout::modal( 'asyncEditServiceModal', ServiceEditLayout::class )
                ->async( 'asyncGetService' ),
            Layout::modal( 'asyncAddServiceModal', ServiceEditLayout::class ),

            Layout::modal( 'asyncEditVideoModal', VideoEditLayout::class )
                ->size( Modal::SIZE_LG )
                ->async( 'asyncGetVideo' ),

            Layout::modal( 'asyncAddVideoModal', VideoEditLayout::class )
                ->size( Modal::SIZE_LG ),

            Layout::modal( 'asyncEditSocialModal', SocialEditLayout::class )
                ->async( 'asyncGetSocial' ),
            Layout::modal( 'asyncAddSocialModal', SocialEditLayout::class ),

            Layout::modal( 'asyncEditWorkingHourModal', WorkingHourEditLayout::class )
                ->async( 'asyncGetWorkingHour' ),
        ];
    }

    public function asyncGetService( Service $model ) : iterable
    {
        return [
            'service' => $model
        ];
    }

    public function updateService( Request $request ) : void
    {
        $service = Service::find( $request->get( 'id' ) );
        if ( $service === null ) {
            Toast::error( __( 'Услуга не найдена' ) );
            return;
        }

        $service->fill(
            $request
                ->collect( 'service' )
                ->only( [
                    'name',
                    'type',
                    'is_start_price',
                    'price',
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Услуга успешно обновлена' ) );
    }

    public function addService( Request $request ) : void
    {
        $model  = Service::make();
        $insert = $request
            ->collect( 'service' )
            ->only( [
                'name',
                'type',
                'is_start_price',
                'price',
            ] )
            ->toArray();
        $insert[ 'is_start_price' ] = (int) $insert[ 'is_start_price' ];
        $insert[ 'profile_id' ]     = $request->get( 'profile_id' );
        $insert[ 'contact_id' ]     = $request->get( 'contact_id' );
        $insert[ 'status' ]         = ServiceStatuses::ON;
        $insert[ 'currency' ]       = CurrencyTypes::RUB;

        $model->fill( $insert )->save();

        Toast::info( __( 'Услуга успешно добавлена' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function removeService( Request $request ): void
    {
        Service::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Услуга удалена' ) );
    }

    // ======================================================================

    public function asyncGetVideo( Video $model ) : iterable
    {
        return [
            'video' => $model
        ];
    }

    public function updateVideo( Request $request ) : void
    {
        $video = Video::find( $request->get( 'id' ) );
        if ( $video === null ) {
            Toast::error( __( 'Видео не найдено' ) );
            return;
        }

        $video->fill(
            $request
                ->collect( 'video' )
                ->only( [
                    'url',
                    'preview',
                    'name',
                    'html',
                    'text'
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Видео успешно обновлено' ) );
    }

    public function addVideo( Request $request ) : void
    {
        $is_add = false;
        $model  = Video::make();
        $insert = $request
            ->collect( 'video' )
            ->only( [
                'url',
                'preview',
                'name',
                'html',
                'text'
            ] )
            ->toArray();
        $insert[ 'profile_id' ] = $request->get( 'profile_id' );
        $insert[ 'contact_id' ] = $request->get( 'contact_id' );
        $insert[ 'meta' ] ??= [];
        $insert[ 'name' ] ??= '';
        $insert[ 'html' ] ??= '';
        $insert[ 'text' ] ??= '';

        try {
            $is_add = $model->fill( $insert )->save();
            VideoAddEvent::dispatch( $model->id );
        } catch ( Exception ) {}

        $is_add
            ? Toast::info( __( 'Видео успешно добавлено' ) )
            : Toast::error( __( 'Не удалось сохранить' ) );;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function removeVideo( Request $request ): void
    {
        Video::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Видео удалено' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function parseVideo( Request $request ): void
    {
        $id = (int) $request->get( 'id' );
        VideoReParseEvent::dispatch( $id );
        Toast::info( __( 'Запущен процесс парсинга' ) );
    }

    // ======================================================================

    public function asyncGetSocial( SocialNetwork $model ) : iterable
    {
        return [
            'social' => $model
        ];
    }

    public function updateSocial( Request $request ) : void
    {
        $social = SocialNetwork::find( $request->get( 'id' ) );
        if ( $social === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        $social->fill(
            $request
                ->collect( 'social' )
                ->only( [
                    'sn_id',
                    'value',
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Социал сеть успешно обновлена' ) );
    }

    public function addSocial( Request $request ) : void
    {
        $model  = SocialNetwork::make();
        $insert = $request
            ->collect( 'social' )
            ->only( [
                'sn_id',
                'value',
            ] )
            ->toArray();
        $insert[ 'status' ]     = SocialNetworkStatuses::ENABLED;
        $insert[ 'profile_id' ] = $request->get( 'profile_id' );
        $insert[ 'contact_id' ] = $request->get( 'contact_id' );

        $model->fill( $insert )->save();

        Toast::info( __( 'Социал сеть успешно добавлена' ) );
    }

    /**
     * @param Request $request
     * @return void
     */
    public function removeSocial( Request $request ): void
    {
        SocialNetwork::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Социал сеть удалена' ) );
    }

    // ======================================================================

    public function asyncGetWorkingHour( WorkingHours $model ) : iterable
    {
        return [
            'wh' => $model
        ];
    }

    public function updateWorkingHour( Request $request ) : void
    {
        $wh = WorkingHours::find( $request->get( 'id' ) );
        if ( $wh === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        $wh->fill(
            $request
                ->collect( 'wh' )
                ->only( [
                    'start',
                    'end',
                    'is_weekend',
                    'is_nonstop'
                ] )
                ->toArray()
        )->save();

        Toast::info( __( 'Рабочее время успешно обновлено' ) );
    }

    // ======================================================================

    public function updateGeneral( Request $request ) : void
    {
        /** @var Contact $salon */
        $salon = Contact::with( [ 'cover' ] )->find( $request->get( 'contact_id' ) );
        if ( $salon === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        // обновление основной информации
        $salon->fill(
            $request
                ->collect( 'salon' )
                ->only( [
                    'alias',
                    'name',
                    'description',
                    'additional_filled_percent',
                ] )
                ->toArray()
        )->save();

        // обновление обложки
        $cover = $request->get( 'salon' )[ 'cover' ][ 'url' ] ?? '';
        if ( $cover !== '' && !str_contains( $cover, 'original' ) ) {
            // анализируем и сохраняем в новом месте
            $new_cover    = Attachment::where( 'name', '=', pathinfo( $cover, PATHINFO_FILENAME ) )->first();
            $path_to_file = Storage::disk( $new_cover->disk )->path( $new_cover->physicalPath() );
            $new_path     = storage_path( '/app/images/original/' . basename( $cover ) );
            File::copy( $path_to_file, $new_path );

            // создаем запись в нужной таблице и связываем с этим салоном
            $file = Pic::make( [
                'original'  => basename( $cover ),
                'size'      => $new_cover->size,
                'mime_type' => $new_cover->mime,
                'thumbs'    => [],
            ] );
            $file->user_id = Auth::user()->id;
            $file->fileable()->associate( $salon )->save();

            // удаляем временный файл
            $new_cover->delete();

            // создание задачи для мелких картинок
            $dto = FileDTO::fromModel( $file );
            UploadedImageEvent::dispatch( $dto );
        }

        // удаление обложки
        if ( $cover === '' && $salon->cover !== null ) {
            $salon->cover()->delete();
        }

        Toast::info( __( 'Общая информация успешно обновлена' ) );
    }

    // ======================================================================

    public function updateAdditionalService(
        UpdateAdditionalServicesRequest $request,
        AdditionalServiceService $additional_service_service,
    ) : void
    {
        /** @var Contact $salon */
        $salon = Contact::with( [ 'additionalServices' ] )->find( $request->get( 'contact_id' ) );
        if ( $salon === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        if ( $additional_service_service->sync(
                DTOHelper::getDTOCollection( AdditionalServiceDTO::class, $request ), $salon ) === false )
        {
            Toast::error( __( 'Доп.услуги не удалось обновить' ) );
            return;
        }

        Toast::info( __( 'Доп.услуги успешно обновлены' ) );
    }

    // ======================================================================

    public function updateContact( Request $request ) : void
    {
        $salon = Contact::find( $request->get( 'contact_id' ) );
        if ( $salon === null ) {
            Toast::error( __( 'Запись не найдена' ) );
            return;
        }

        $insert = $request
            ->collect( 'salon' )
            ->only( [
                'country_id',
                'city_id',
                'metro_id',
                'address',
                'district',
                'site',
                'email',
                'phone',
            ] )
            ->toArray();

        $insert[ 'lat' ] = $request->get( 'place', [] )[ 'lat' ] ?? 0.0;
        $insert[ 'lon' ] = $request->get( 'place', [] )[ 'lng' ] ?? 0.0;

        $salon->fill( $insert )->save();
        Toast::info( __( 'Контакты успешно обновлены' ) );
    }

    // ======================================================================

    /**
     * @param Request $request
     * @return void
     */
    public function removeReview( Request $request ): void
    {
        Review::findOrFail( $request->get( 'id' ) )->delete();
        Toast::info( __( 'Отзыв удален' ) );
    }
}
