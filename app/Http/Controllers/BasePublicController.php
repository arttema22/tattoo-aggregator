<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\CityService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\View;

class BasePublicController extends Controller
{
    /**
     * @var \App\Services\CityService
     */
    protected CityService $city_service;

    /**
     * @var \App\Services\CategoryService
     */
    protected CategoryService $category_service;

    public function __construct()
    {
        $this->city_service = app()->make( CityService::class );
        $this->category_service = app()->make( CategoryService::class );

        $this->menuSalonByCity();
        $this->menuCategoryArticle();
    }

    private function menuSalonByCity() : void
    {
        $salon_by_city = config( 'main_menu.catalog_by_city' );
        $cities = $this->city_service->getAll();

        $data = [];
        foreach ( $cities as $city ) {
            if ( !in_array( $city->name[ 'ru' ], $salon_by_city, true ) ) {
                continue;
            }

            $data[] = [
                'alias' => $city->alias,
                'name'  => $city->name[ 'ru' ]
            ];
        }

        View::share( 'catalog_by_city', $data );
    }

    private function menuCategoryArticle() : void
    {
        $categories = $this->category_service->getAll();
        View::share( 'categories_for_article', $categories );
    }
}
