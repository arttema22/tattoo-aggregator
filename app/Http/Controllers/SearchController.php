<?php

namespace App\Http\Controllers;

use App\Enums\SpecializationTypeNames;
use App\Enums\SpecializationTypes;
use App\Enums\WorkApproved;
use App\Filters\FileInfoFilter;
use App\Filters\FilterPageFilter;
use App\Helpers\DictionaryHelper;
use App\Helpers\SearchFilterHelper;
use App\Helpers\SpecialisationDictionaryHelper;
use App\Helpers\SpecialisationTypeHelper;
use App\Http\Requests\Search\SearchPiercingRequest;
use App\Http\Requests\Search\SearchTattooRequest;
use App\Http\Requests\Search\SearchTatuajeRequest;
use App\Models\Dictionaries\GenderDictionary;
use App\Models\Dictionaries\PiercingPlaceDictionary;
use App\Models\Dictionaries\TattooPlaceDictionary;
use App\Models\Dictionaries\TattooSizeDictionary;
use App\Models\Dictionaries\TattooStyleDictionary;
use App\Models\Dictionaries\TattooTempTypeDictionary;
use App\Models\Dictionaries\TatuajePlaceDictionary;
use App\Models\FileInfo;
use App\Services\FileInfoService;
use App\Services\FilterPageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class SearchController extends BasePublicController
{
    private int $count_per_page;
    private int $landing_page_works_per_page;

    /**
     * SearchController constructor.
     * @param FileInfoService $file_info_service
     * @param FilterPageService $filter_page_service
     */
    public function __construct(
        private FileInfoService $file_info_service,
        private FilterPageService $filter_page_service,
    )
    {
        parent::__construct();

        $this->count_per_page = config( 'search.count_per_page' );
        $this->landing_page_works_per_page = config( 'landing-page.works_per_page' );
    }

    public function searchTattoo( SearchTattooRequest $request, string $filter = '' )
    {
        $filter_slugs = $filter;
        $main_filter_slugs =
            DictionaryHelper::groupFilterSlugsByType(
                SpecializationTypes::TATTOO,
                $filter_slugs );

        $selected_genders =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::gender( true ),
                $request->get( 'gender', [] ),
                $main_filter_slugs[ GenderDictionary::TYPE ] ?? '' );
        $selected_places =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooPlace( true ),
                $request->get( 'place', [] ),
                $main_filter_slugs[ TattooPlaceDictionary::TYPE ] ?? '' );
        $selected_styles =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooStyle( true ),
                $request->get( 'style', [] ),
                $main_filter_slugs[ TattooStyleDictionary::TYPE ] ?? '' );
        $selected_sizes =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooSize( true ),
                $request->get( 'size', [] ),
                $main_filter_slugs[ TattooSizeDictionary::TYPE ] ?? '' );
        $selected_temp_types =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooTempType( true ),
                $request->get( 'tempType', [] ),
                $main_filter_slugs[ TattooTempTypeDictionary::TYPE ] ?? '' );

        $filter = app()->make( FileInfoFilter::class, [ $request ] );
        $filter->setCustomFields( array_filter( [
            'type'           => SpecializationTypes::TATTOO,
            'gender'         => $selected_genders->keys()->all(),
            'tattooPlace'    => $selected_places->keys()->all(),
            'tattooStyle'    => $selected_styles->keys()->all(),
            'tattooSize'     => $selected_sizes->keys()->all(),
            'tattooTempType' => $selected_temp_types->keys()->all(),
            'is_approved'    => WorkApproved::APPROVE,
        ], static fn ( $item ) => $item ) );

        $search_result = $this->file_info_service->searchForCatalog( $filter, $this->count_per_page );

        $search_filter = app()->make( FilterPageFilter::class );
        $search_filter->setCustomFields( [ 'type' => SpecializationTypes::TATTOO, 'slug' => $filter_slugs ] );
        $filter_page = $this->filter_page_service->get( $search_filter );
        $search_title = $filter_page !== null
            ? $filter_page->title
            : SpecialisationTypeHelper::titleFromName( SpecializationTypeNames::TATTOO );
        $search_description = $filter_page?->description ?? '';
        $search_keywords    = $filter_page?->keywords ?? '';

        $selected_filters =
            $selected_genders->keys()
                ->merge($selected_places->keys())
                ->merge($selected_styles->keys())
                ->merge($selected_sizes->keys())
                ->merge($selected_temp_types->keys())
                ->toArray();
        $related_filter_pages = $this->filter_page_service->searchRelated( SpecializationTypes::TATTOO, $selected_filters );

        return view(
            'page.search',
            [
                'title'         => $search_title . ' | ' . config('app.name', 'Tattoo'),
                'description'   => $search_description,
                'keywords'      => $search_keywords,
                'search_result' => $search_result,
                'search_title'  => $search_title,
                'type'          => SpecializationTypeNames::TATTOO,
                'filters'       => [
                    [
                        'name'     => 'gender',
                        'title'    => 'Пол',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::gender( true ), $selected_genders ),
                        'selected' => $selected_genders->pluck( 'slug' )->all(),
                    ],
                    [
                        'name'     => 'place',
                        'title'    => 'Место',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::tattooPlace( true ), $selected_places ),
                        'selected' => $selected_places->pluck( 'slug' )->all(),
                    ],
                    [
                        'name'     => 'style',
                        'title'    => 'Стиль',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::tattooStyle( true ), $selected_styles ),
                        'selected' => $selected_styles->pluck( 'slug' )->all(),
                    ],
                    [
                        'name'     => 'size',
                        'title'    => 'Размер',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::tattooSize( true ), $selected_sizes ),
                        'selected' => $selected_sizes->pluck( 'slug' )->all(),
                    ],
                    [
                        'name'     => 'tempType',
                        'title'    => 'Тип',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::tattooTempType( true ), $selected_temp_types ),
                        'selected' => $selected_temp_types->pluck( 'slug' )->all(),
                    ],
                ],
                'dictionaries' => current( SpecialisationDictionaryHelper::get( SpecializationTypes::TATTOO ) ),
                'related_filter_pages' => $related_filter_pages,
            ]
        );
    }

    public function searchPiercing( SearchPiercingRequest $request, string $filter = '' )
    {
        $filter_slugs = $filter;
        $main_filter_slugs =
            DictionaryHelper::groupFilterSlugsByType(
                SpecializationTypes::PIERCING,
                $filter_slugs );

        $selected_genders =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::gender( true ),
                $request->get( 'gender', [] ),
                $main_filter_slugs[ GenderDictionary::TYPE ] ?? '' );
        $selected_places =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::piercingPlace( true ),
                $request->get( 'place', [] ),
                $main_filter_slugs[ PiercingPlaceDictionary::TYPE ] ?? '' );

        $filter = app()->make( FileInfoFilter::class, [ $request ] );
        $filter->setCustomFields( array_filter( [
            'type'          => SpecializationTypes::PIERCING,
            'gender'        => $selected_genders->keys()->all(),
            'piercingPlace' => $selected_places->keys()->all(),
            'is_approved'   => WorkApproved::APPROVE,
        ], static fn ( $item ) => $item ) );

        $search_result = $this->file_info_service->searchForCatalog( $filter, $this->count_per_page );
        $search_filter = app()->make( FilterPageFilter::class );
        $search_filter->setCustomFields( [ 'type' => SpecializationTypes::PIERCING, 'slug' => $filter_slugs ] );
        $filter_page = $this->filter_page_service->get( $search_filter );
        $search_title = $filter_page !== null
            ? $filter_page->title
            : SpecialisationTypeHelper::titleFromName( SpecializationTypeNames::PIERCING );

        $selected_filters = $selected_genders->keys()->merge($selected_places->keys())->toArray();
        $related_filter_pages = $this->filter_page_service->searchRelated( SpecializationTypes::PIERCING, $selected_filters );

        return view(
            'page.search',
            [
                'title'         => $search_title . ' | ' . config('app.name', 'Tattoo'),
                'search_result' => $search_result,
                'search_title'  => $search_title,
                'type'          => SpecializationTypeNames::PIERCING,
                'filters'       => [
                    [
                        'name'     => 'gender',
                        'title'    => 'Пол',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::gender( true ), $selected_genders ),
                        'selected' => $selected_genders->pluck( 'slug' )->all(),
                    ],
                    [
                        'name'     => 'place',
                        'title'    => 'Место/Тип',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::piercingPlace( true ), $selected_places ),
                        'selected' => $selected_places->pluck( 'slug' )->all(),
                    ],
                    [
                        'name'     => 'piercingHealingPeriod',
                        'title'    => 'Период заживления, недели',
                        'type'     => 'Range',
                        'data'     => [ 'От', 'До' ],
                        'selected' => $request->get( 'piercingHealingPeriod', [] ),
                    ],
                    [
                        'name'     => 'piercingPainLevel',
                        'title'    => 'Уровень боли',
                        'type'     => 'Range',
                        'data'     => [ 'От', 'До' ],
                        'selected' => $request->get( 'piercingPainLevel', [] ),
                    ],
                ],
                'dictionaries' => current( SpecialisationDictionaryHelper::get( SpecializationTypes::PIERCING ) ),
                'related_filter_pages' => $related_filter_pages,
            ]
        );
    }

    public function searchTatuaje( SearchTatuajeRequest $request, string $filter = '' )
    {
        $filter_slugs = $filter;
        $main_filter_slugs =
            DictionaryHelper::groupFilterSlugsByType(
                SpecializationTypes::TATUAJE,
                $filter_slugs );

        $selected_places =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tatuajePlace( true ),
                $request->get( 'place', [] ),
                $main_filter_slugs[ TatuajePlaceDictionary::TYPE ] ?? '' );

        $filter = app()->make( FileInfoFilter::class, [ $request ] );
        $filter->setCustomFields( array_filter( [
            'type'         => SpecializationTypes::TATUAJE,
            'tatuajePlace' => $selected_places->keys()->all(),
            'is_approved'  => WorkApproved::APPROVE,
        ], static fn ( $item ) => $item ) );

        $search_result = $this->file_info_service->searchForCatalog( $filter, $this->count_per_page );
        $search_filter = app()->make( FilterPageFilter::class );
        $search_filter->setCustomFields( [ 'type' => SpecializationTypes::TATUAJE, 'slug' => $filter_slugs ] );
        $filter_page = $this->filter_page_service->get( $search_filter );
        $search_title = $filter_page !== null
            ? $filter_page->title
            : SpecialisationTypeHelper::titleFromName( SpecializationTypeNames::TATUAJE );

        $selected_filters = $selected_places->keys()->toArray();
        $related_filter_pages = $this->filter_page_service->searchRelated( SpecializationTypes::TATUAJE, $selected_filters );

        return view(
            'page.search',
            [
                'title'         => $search_title . ' | ' . config('app.name', 'Tattoo'),
                'search_result' => $search_result,
                'search_title'  => $search_title,
                'type'          => SpecializationTypeNames::TATUAJE,
                'filters'       => [
                    [
                        'name'     => 'place',
                        'title'    => 'Место',
                        'type'     => 'Checkbox',
                        'data'     => SearchFilterHelper::sortBySelected( DictionaryHelper::tatuajePlace( true ), $selected_places ),
                        'selected' => $selected_places->pluck( 'slug' )->all(),
                    ],
                ],
                'dictionaries' => current( SpecialisationDictionaryHelper::get( SpecializationTypes::TATUAJE ) ),
                'related_filter_pages' => $related_filter_pages,
            ]
        );
    }

    private function prepareWorksDataForResponse( Collection $items ): Collection
    {
        return $items->map(
            fn( FileInfo $item ) => [
                'file' => $item->file->original,
                'name' => $item->name,
                'description' => $item->description,
                'url' => route( 'work.full', [
                    'salon' => $item->file->fileable->contact->alias,
                    'album_id' => $item->file->fileable->id,
                    'file_id' => $item->file->id
                ] ),
            ],
        );
    }

    public function searchCityTattoo(
        SearchTattooRequest $request,
        FileInfoFilter $filter,
        string $city
    ): JsonResponse {
        $selected_genders =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::gender( true ),
                $request->get( 'gender', [] ) );
        $selected_places =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooPlace( true ),
                $request->get( 'place', [] ) );
        $selected_styles =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooStyle( true ),
                $request->get( 'style', [] ) );
        $selected_sizes =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooSize( true ),
                $request->get( 'size', [] ) );
        $selected_temp_types =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tattooTempType( true ),
                $request->get( 'tempType', [] ) );

        $filter->setCustomFields( array_filter( [
            'type'           => SpecializationTypes::TATTOO,
            'gender'         => $selected_genders->keys()->all(),
            'tattooPlace'    => $selected_places->keys()->all(),
            'tattooStyle'    => $selected_styles->keys()->all(),
            'tattooSize'     => $selected_sizes->keys()->all(),
            'tattooTempType' => $selected_temp_types->keys()->all(),
            'is_approved'    => WorkApproved::APPROVE,
            'city'           => $city,
            'limit'          => $this->landing_page_works_per_page,
        ], static fn ( $item ) => $item ) );

        $data = $this->file_info_service->searchForCatalog( $filter );
        return response()->json( $this->prepareWorksDataForResponse( $data ) );
    }

    public function searchCityPiercing(
        SearchPiercingRequest $request,
        FileInfoFilter $filter,
        string $city
    ): JsonResponse {
        $selected_genders =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::gender( true ),
                $request->get( 'gender', [] ) );
        $selected_places =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::piercingPlace( true ),
                $request->get( 'place', [] ) );

        $filter->setCustomFields( array_filter( [
            'type'          => SpecializationTypes::PIERCING,
            'gender'        => $selected_genders->keys()->all(),
            'piercingPlace' => $selected_places->keys()->all(),
            'is_approved'   => WorkApproved::APPROVE,
            'city'          => $city,
            'limit'         => $this->landing_page_works_per_page,
        ], static fn ( $item ) => $item ) );

        $data = $this->file_info_service->searchForCatalog( $filter );
        return response()->json( $this->prepareWorksDataForResponse( $data ) );
    }

    public function searchCityTatuaje(
        SearchTatuajeRequest $request,
        FileInfoFilter $filter,
        string $city
    ): JsonResponse {
        $selected_places =
            DictionaryHelper::getSelectedDictionaries(
                DictionaryHelper::tatuajePlace( true ),
                $request->get( 'place', [] ) );

        $filter->setCustomFields( array_filter( [
            'type'         => SpecializationTypes::TATUAJE,
            'tatuajePlace' => $selected_places->keys()->all(),
            'is_approved'  => WorkApproved::APPROVE,
            'city'         => $city,
            'limit'        => $this->landing_page_works_per_page,
        ], static fn ( $item ) => $item ) );

        $data = $this->file_info_service->searchForCatalog( $filter );
        return response()->json( $this->prepareWorksDataForResponse( $data ) );
    }
}
