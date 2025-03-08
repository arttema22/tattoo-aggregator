<?php

namespace App\Http\Controllers;

use App\Enums\WorkApproved;
use App\Filters\ContactFilter;
use App\Filters\FileInfoFilter;
use App\Filters\LandingPageFilter;
use App\Filters\LandingPageServiceFilter;
use App\Helpers\BreadcrumbsHelper;
use App\Helpers\DictionaryHelper;
use App\Helpers\SearchFilterHelper;
use App\Helpers\SpecialisationTypeHelper;
use App\Services\ContactService;
use App\Services\FileInfoService;
use App\Services\LandingPagePriceService;
use App\Services\LandingPageService;
use App\Services\LandingPageTagService;
use App\Services\ReviewService;

class LandingPageController extends BasePublicController
{
    private int $salons_per_page;
    private int $works_per_page;
    private int $reviews_per_page;

    public function __construct(
        private LandingPageService $landing_page_service,
        private ContactService $contact_service,
        private FileInfoService $file_info_service,
        private ReviewService $review_service,
        private LandingPageTagService $landing_page_tag_service,
        private LandingPagePriceService $landing_page_price_service,
    ) {
        parent::__construct();

        $this->salons_per_page = config( 'landing-page.salons_per_page' );
        $this->works_per_page  = config( 'landing-page.works_per_page' );
        $this->reviews_per_page  = config( 'landing-page.reviews_per_page' );
    }

    public function index( string $city, string $landing_page_name )
    {
        $landing_page_filter = app()->make( LandingPageFilter::class );
        $landing_page_filter->setCustomFields( [ 'cityAlias' => $city, 'slug' => $landing_page_name ] );

        $landing_page = $this->landing_page_service->get( $landing_page_filter );
        if ( $landing_page === null ) {
            abort( 404 );
        }

        $contact_filter = app()->make( ContactFilter::class );
        $contact_filter->setCustomFields( [ 'cityAlias' => $city, 'mostFilled' => true ] );

        $file_info_custom_fields = [
            'type'        => $landing_page->type,
            'city'        => $city,
            'is_approved' => WorkApproved::APPROVE,
            'limit'       => $this->works_per_page,
        ];

        $reviews = $landing_page->reviews;
        if ( $reviews->count() !== $this->reviews_per_page ) {
            // TODO пока что полный рандом, в дальнейшем можно учитывать город?
            $reviews = $this->review_service->getRandom( $this->reviews_per_page );
            $this->landing_page_service->syncReviews( $landing_page, $reviews->pluck( 'id' ) );
        }

        $grouped_dictionary_ids = DictionaryHelper::groupDictionaryIdsByType( $landing_page->type, $landing_page->dictionary );
        foreach ( $grouped_dictionary_ids as $dictionary_type => $dictionary_id ) {
            $file_info_custom_fields[ DictionaryHelper::getFilterNameFromDictionaryType( $dictionary_type ) ] = $dictionary_id;
        }

        $file_info_filter = app()->make( FileInfoFilter::class );
        $file_info_filter->setCustomFields( $file_info_custom_fields );

        $works = $this->file_info_service->searchForCatalog( $file_info_filter );

        $price_filter = app(LandingPageServiceFilter::class);
        $price_filter->setCustomFields( [ 'landingPage' => $landing_page->id ] );
        $prices = app(LandingPagePriceService::class)->search($price_filter);

        return view( 'page.landing.index', [
            'breadcrumbs'    => BreadcrumbsHelper::getForLandingPage( $landing_page ),
            'title'          => $landing_page->title,
            'caption'        => $landing_page->caption,
            'description'    => $landing_page->description,
            'keywords'       => $landing_page->keywords,
            'seo_text'       => $landing_page->seo_text,
            'type'           => SpecialisationTypeHelper::getTypeFromId( $landing_page->type ),
            'city'           => $landing_page->city,
            'salons'         => $this->contact_service->search( $contact_filter, $this->salons_per_page ),
            'all_salons'     => $this->contact_service->getAllShort( $contact_filter ),
            'reviews'        => $reviews,
            'salons_filters' => [
                'city' => [
                    'dictionary' => $this->city_service->getByCountry( 1 ),
                    'selected'   => $city,
                ],
                'tattoo' => [
                    'dictionary' => DictionaryHelper::tattooPlace( true ),
                    'selected'   => DictionaryHelper::tattooPlace( true )->whereIn( 'id', $landing_page->dictionary )->pluck( 'slug' )->first() ?: '-',
                ],
                'piercing' => [
                    'dictionary' => DictionaryHelper::piercingPlace( true ),
                    'selected'   => DictionaryHelper::piercingPlace( true )->whereIn( 'id', $landing_page->dictionary )->pluck( 'slug' )->first() ?: '-',
                ],
                'tatuaje' => [
                    'dictionary' => DictionaryHelper::tatuajePlace( true ),
                    'selected'   => DictionaryHelper::tatuajePlace( true )->whereIn( 'id', $landing_page->dictionary )->pluck( 'slug' )->first() ?: '-',
                ],
            ],
            'works' => [
                'result'  => $works,
                'filters' => SearchFilterHelper::getFiltersByType( $landing_page->type, $landing_page->dictionary ),
            ],
            'tags' => $this->landing_page_tag_service->get( $landing_page->id ),
            'user_tags' => $landing_page->landingPageUserTags,
            'prices' => $prices,
        ] );
    }
}
