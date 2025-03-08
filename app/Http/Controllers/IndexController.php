<?php

namespace App\Http\Controllers;

use App\Enums\SpecializationTypeNames;
use App\Enums\SpecializationTypes;
use App\Enums\WorkApproved;
use App\Filters\ArticleFilter;
use App\Filters\FileInfoFilter;
use App\Helpers\SpecialisationDictionaryHelper;
use App\Services\ArticleService;
use App\Services\FileInfoService;

class IndexController extends BasePublicController
{
    /**
     * @var ArticleService
     */
    private ArticleService $article_service;

    /**
     * @var FileInfoService
     */
    private FileInfoService $file_info_service;

    private int $top_works_count;

    public function __construct( ArticleService $article_service, FileInfoService $file_info_service )
    {
        parent::__construct();

        $this->article_service   = $article_service;
        $this->file_info_service = $file_info_service;

        $this->top_works_count = config( 'top-works.count' );
    }

    public function index( ArticleFilter $filter )
    {
        $filter->setCustomFields( [ 'lastPublished' => true, 'limit' => 4 ] );
        $articles = $this->article_service->search( $filter );

        $file_info_filter = new FileInfoFilter();
        $file_info_filter->setCustomFields( [ 'type' => SpecializationTypes::TATTOO, 'is_approved' => WorkApproved::APPROVE ] );
        $top_tattoo = $this->file_info_service->searchForCatalog( $file_info_filter, $this->top_works_count );

        $file_info_filter->setCustomFields( [ 'type' => SpecializationTypes::PIERCING, 'is_approved' => WorkApproved::APPROVE ] );
        $top_piercing = $this->file_info_service->searchForCatalog( $file_info_filter, $this->top_works_count );

        $file_info_filter->setCustomFields( [ 'type' => SpecializationTypes::TATUAJE, 'is_approved' => WorkApproved::APPROVE ] );
        $top_tatuaje = $this->file_info_service->searchForCatalog( $file_info_filter, $this->top_works_count );

        return view(
            'page.index',
            [
                'title'        => 'Все тату салоны России и СНГ: отзывы, цены, фото, услуги, рейтинг',
                'description'  => 'Каталог тату салонов, студий и тату-мастеров в России и СНГ. Адреса, фото, условия, стили, цены и контакты. Рейтинг лучших студий.',
                'articles'     => $articles,
                'top_works'    => [
                     [
                        'type' => SpecializationTypeNames::TATTOO,
                        'title' => 'Топ тату работ',
                        'works'  => $top_tattoo
                    ],
                    [
                        'type' => SpecializationTypeNames::PIERCING,
                        'title' => 'Топ пирсинг работ',
                        'works' => $top_piercing
                    ],
                    [
                        'type' => SpecializationTypeNames::TATUAJE,
                        'title' => 'Топ татуаж работ',
                        'works' => $top_tatuaje
                    ]
                ],
                'dictionaries' =>
                    SpecialisationDictionaryHelper::get(
                        SpecializationTypes::TATTOO |
                        SpecializationTypes::TATUAJE |
                        SpecializationTypes::PIERCING )
            ]
        );
    }
}
