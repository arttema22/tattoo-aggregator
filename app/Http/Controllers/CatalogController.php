<?php

namespace App\Http\Controllers;

use App\Filters\AdditionalServiceNameFilter;
use App\Filters\ArticleFilter;
use App\Filters\ContactFilter;
use App\Helpers\DictionaryHelper;
use App\Services\AdditionalServiceNameService;
use App\Services\ArticleService;
use App\Services\ContactService;
use App\Services\MetroService;
use Illuminate\Http\Request;

class CatalogController extends BasePublicController
{
    /**
     * @var int
     */
    private int $count_per_page;


    public function __construct(
        private ContactService $contact_service,
        private ArticleService $article_service,
        private MetroService $metro_service,
        private AdditionalServiceNameService $additional_service_name_service,
    )
    {
        parent::__construct();

        $this->count_per_page  = config( 'salon.count_per_page' );
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function index( Request $request )
    {
        $article_filter = app()->make( ArticleFilter::class, [ $request ] );
        $article_filter->setCustomFields( [ 'lastPublished' => true, 'limit' => 4 ] );

        $additional_service_name_filter = app()->make( AdditionalServiceNameFilter::class, [ $request ] );
        $additional_service_name_filter->setCustomFields( [
            'ids' => [ config( 'salon.filters.additional_service' ) ]
        ] );

        $contact_filter = app()->make( ContactFilter::class, [ $request ] );
        $contact_filter->setCustomFields( [ 'mostFilled' => true ] );

        return view(
            'page.catalog',
            [
                'title'    => 'Каталог салонов | ' . config('app.name', 'TatuGuru'),
                'salons'   => $this->contact_service->search( $contact_filter, $this->count_per_page ),
                'articles' => $this->article_service->search( $article_filter ),
                'filter'   => [
                    'city' => $this->city_service->getByCountry( 1 ),
                    'additional_service_name' => $this->additional_service_name_service->search( $additional_service_name_filter ),
                    'piercing' => [
                        'place' => DictionaryHelper::piercingPlace(),
                    ],
                    'tatuaje' => [
                        'place' => DictionaryHelper::tatuajePlace()
                    ]
                ],
                'selected' => [
                    'city'  => '-',
                    'additional_service_name' => $request->get( 'additionalService', [] ),
                    'piercing' => [
                        'place' => $request->get( 'piercingPlace', '-' ),
                    ],
                    'tatuaje' => [
                        'place' => $request->get( 'tatuajePlace', '-' )
                    ]
                ],
                'city_group' => $this->city_service->getCountContacts(),
            ]
        );
    }

    public function getByCity( Request $request, string $city_alias )
    {
        $article_filter = app()->make( ArticleFilter::class, [ $request ] );
        $contact_filter = app()->make( ContactFilter::class, [ $request ] );

        $article_filter->setCustomFields( [ 'lastPublished' => true, 'limit' => 4 ] );
        $contact_filter->setCustomFields( [ 'cityAlias' => $city_alias, 'mostFilled' => true ] );

        $additional_service_name_filter = app()->make( AdditionalServiceNameFilter::class, [ $request ] );
        $additional_service_name_filter->setCustomFields( [
            'ids' => [ config( 'salon.filters.additional_service' ) ]
        ] );

        $city = $this->city_service->getNameByAlias( $city_alias );
        if ( $city === null ) {
            abort( 404 );
        }

        return view(
            'page.catalog',
            [
                'title'    => 'Каталог салонов в ' . $city->name[ 'ru' ] . ' | ' . config('app.name', 'TatuGuru'),
                'description' => sprintf( 'Каталог тату салонов, студий и тату мастеров в %s. Адреса, фото, условия, стили, цены и контакты. Рейтинг лучших', $city->name[ 'ru' ] ),
                'filter_by'=> $city->name[ 'ru' ],
                'salons'   => $this->contact_service->search( $contact_filter, $this->count_per_page ),
                'articles' => $this->article_service->search( $article_filter ),
                'filter'   => [
                    'city'  => $this->city_service->getByCountry( 1 ), // fixme желательно переделать
                    'metro' => $this->metro_service->getByCity( $city_alias ),
                    'additional_service_name' => $this->additional_service_name_service->search( $additional_service_name_filter ),
                    'piercing' => [
                        'place' => DictionaryHelper::piercingPlace(),
                    ],
                    'tatuaje' => [
                        'place' => DictionaryHelper::tatuajePlace()
                    ]

                ],
                'selected' => [
                    'city'  => $city_alias,
                    'metro' => $request->get( 'metro', '-' ),
                    'additional_service_name' => $request->get( 'additionalService', [] ),
                    'piercing' => [
                        'place' => $request->get( 'piercingPlace', '-' ),
                    ],
                    'tatuaje' => [
                        'place' => $request->get( 'tatuajePlace', '-' )
                    ]
                ],
                'city_group' => collect([]),
                'city' => $city,
                'all_salons' => $this->contact_service->getAllShort( $contact_filter )
            ]
        );
    }
}
