<?php

namespace App\Http\Controllers;

use App\Filters\AdditionalServiceFilter;
use App\Filters\AlbumFilter;
use App\Filters\ArticleFilter;
use App\Filters\ContactFilter;
use App\Filters\ReviewFilter;
use App\Filters\ServiceFilter;
use App\Filters\SocialNetworkFilter;
use App\Filters\VideoFilter;
use App\Filters\WorkingHoursFilter;
use App\Helpers\SalonHelper;
use App\Services\AdditionalServiceService;
use App\Services\AlbumService;
use App\Services\ArticleService;
use App\Services\SalonDistanceService;
use App\Services\ContactService;
use App\Services\ReviewService;
use App\Services\ServiceService;
use App\Services\SocialNetworkService;
use App\Services\VideoService;
use App\Services\WorkingHoursService;

class SalonController extends BasePublicController
{
    public function __construct(
        private ContactService           $contact_service,
        private AdditionalServiceService $additional_service,
        private WorkingHoursService      $working_hours_service,
        private SocialNetworkService     $social_network_service,
        private ServiceService           $service_service,
        private AlbumService             $album_service,
        private VideoService             $video_service,
        private ArticleService           $article_service,
        private ReviewService            $review_service,
        private SalonDistanceService     $salon_distance_service,
    )
    {
        parent::__construct();
    }

    public function index(
        ContactFilter           $contact_filter,
        AdditionalServiceFilter $additional_service_filter,
        WorkingHoursFilter      $working_hours_filter,
        SocialNetworkFilter     $social_network_filter,
        ServiceFilter           $service_filter,
        AlbumFilter             $album_filter,
        VideoFilter             $video_filter,
        ArticleFilter           $article_filter,
        ReviewFilter            $review_filter,
        string                  $alias_contact )
    {
        $contact_filter->setCustomFields( [ 'alias' => $alias_contact ] );
        /** @var \App\Models\Contact $salon */
        $salon = $this->contact_service->search( $contact_filter )->first();

        $custom_fields = [
            'contact' => $salon->id ?? -1,
            'profile' => $salon->profile_id ?? -1,
        ];

        $working_hours_filter->setCustomFields( $custom_fields );
        $working_hours = $this->working_hours_service->get( $working_hours_filter );

        $additional_service_filter->setCustomFields( $custom_fields );
        $additional_service = $this->additional_service->search( $additional_service_filter );

        $social_network_filter->setCustomFields( $custom_fields );
        $social_network = $this->social_network_service->search( $social_network_filter );

        $service_filter->setCustomFields( $custom_fields );
        $services = $this->service_service->search( $service_filter );

        $album_filter->setCustomFields( $custom_fields );
        $albums = $this->album_service->searchWithFiles( $album_filter, true );

        $video_filter->setCustomFields( $custom_fields );
        $videos = $this->video_service->search( $video_filter );

        $article_filter->setCustomFields( [ 'lastPublished' => true, 'limit' => 3 ] );
        $articles = $this->article_service->search( $article_filter );

        $review_filter->setCustomFields( [ 'isApproved' => 1, 'sortByPublish' => 'desc' ] + $custom_fields );
        $reviews = $this->review_service->search( $review_filter, config( 'salon.review_per_page' ) );

        $salons_distance_nearby =
            $this->salon_distance_service->getSalonsNearby(
                $salon->id ?? -1,
                SalonHelper::getNearbyDistanceByCityPopulation( $salon->city->population ) );

        return view( 'page.salon', [
            'title'              => $salon->name . ' в ' . ( $salon->city?->name[ 'ru' ] ?? '' ) . ' | ' . config('app.name', 'Tattoo'),
            'description'        => sprintf( '%s одна из лучших студий татуировки в %s. Сделайте свою татуировку в нашей тату студии. Квалифицированные мастера. Стерильно и безопасно!', $salon->name, $salon->city?->name[ 'ru' ] ?? '' ),
            'salon'              => $salon,
            'additional_service' => $additional_service,
            'working_hours'      => $working_hours,
            'social_network'     => $social_network,
            'services'           => $services,
            'albums'             => $albums,
            'videos'             => $videos,
            'articles'           => $articles,
            'reviews'            => $reviews,
            'salons_nearby'      => SalonHelper::getRandomNearbySalons( $salons_distance_nearby )
        ] );
    }
}
