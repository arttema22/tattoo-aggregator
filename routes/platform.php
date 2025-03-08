<?php

declare(strict_types=1);

use App\Orchid\Screens\Article\ArticleEditScreen;
use App\Orchid\Screens\Article\ArticleListScreen;
use App\Orchid\Screens\Category\CategoryEditScreen;
use App\Orchid\Screens\Category\CategoryListScreen;
use App\Orchid\Screens\Dictionary\DictionaryEditScreen;
use App\Orchid\Screens\Dictionary\DictionaryListScreen;
use App\Orchid\Screens\Image\ImageEditScreen;
use App\Orchid\Screens\Image\ImageListScreen;
use App\Orchid\Screens\LandingPage\LandingPageAddScreen;
use App\Orchid\Screens\LandingPage\LandingPageEditScreen;
use App\Orchid\Screens\LandingPage\LandingPageListScreen;
use App\Orchid\Screens\SearchPage\SearchPageAddScreen;
use App\Orchid\Screens\SearchPage\SearchPageEditScreen;
use App\Orchid\Screens\SearchPage\SearchPageListScreen;
use App\Orchid\Screens\Geo\City\CityEditScreen;
use App\Orchid\Screens\Geo\City\CityListScreen;
use App\Orchid\Screens\Geo\Country\CountryEditScreen;
use App\Orchid\Screens\Geo\Country\CountryListScreen;
use App\Orchid\Screens\Geo\Metro\MetroEditScreen;
use App\Orchid\Screens\Geo\Metro\MetroListScreen;
use App\Orchid\Screens\Geo\MetroLine\MetroLineEditScreen;
use App\Orchid\Screens\Geo\MetroLine\MetroLineListScreen;
use App\Orchid\Screens\Geo\UserCity\UserCityEditScreen;
use App\Orchid\Screens\Geo\UserCity\UserCityListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Review\ReviewEditScreen;
use App\Orchid\Screens\Review\ReviewListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Salon\AlbumEditScreen;
use App\Orchid\Screens\Salon\SalonEditScreen;
use App\Orchid\Screens\Salon\SalonListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/
// Main
Route::screen( '/main', PlatformScreen::class )
    ->name( 'platform.main' );

// Platform > Profile
Route::screen( 'profile', UserProfileScreen::class )
    ->name( 'platform.profile' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Profile' ), route( 'platform.profile' ) );
    } );

// Platform > System > Users
Route::screen( 'users/{user}/edit', UserEditScreen::class )
    ->name( 'platform.systems.users.edit' )
    ->breadcrumbs( function ( Trail $trail, $user ) {
        return $trail
            ->parent( 'platform.systems.users' )
            ->push( __( 'User' ), route( 'platform.systems.users.edit', $user ) );
    } );

// Platform > System > Users > Create
Route::screen( 'users/create', UserEditScreen::class )
    ->name( 'platform.systems.users.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.systems.users' )
            ->push( __( 'Create' ), route( 'platform.systems.users.create' ) );
    } );

// Platform > System > Users > User
Route::screen( 'users', UserListScreen::class )
    ->name( 'platform.systems.users' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Users' ), route( 'platform.systems.users' ) );
    } );

// Platform > System > Roles > Role
Route::screen( 'roles/{role}/edit', RoleEditScreen::class )
    ->name( 'platform.systems.roles.edit' )
    ->breadcrumbs( function ( Trail $trail, $role ) {
        return $trail
            ->parent( 'platform.systems.roles' )
            ->push( __( 'Role' ), route( 'platform.systems.roles.edit', $role ) );
    } );

// Platform > System > Roles > Create
Route::screen( 'roles/create', RoleEditScreen::class )
    ->name( 'platform.systems.roles.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.systems.roles' )
            ->push( __( 'Create' ), route( 'platform.systems.roles.create' ) );
    } );

// Platform > System > Roles
Route::screen( 'roles', RoleListScreen::class )
    ->name( 'platform.systems.roles' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Roles' ), route( 'platform.systems.roles' ) );
    } );

// Блог
Route::screen( 'articles', ArticleListScreen::class )
    ->name( 'platform.articles' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Блог' ), route( 'platform.articles' ) );
    } );

Route::screen( 'articles/create', ArticleEditScreen::class )
    ->name( 'platform.articles.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Блог' ), route( 'platform.articles' ) )
            ->push( __( 'Новая статья' ), route( 'platform.articles.create' ) );
    } );

Route::screen( 'articles/{article}/edit', ArticleEditScreen::class )
    ->name( 'platform.articles.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Блог' ), route( 'platform.articles' ) )
            ->push( __( 'Редактирование статьи' ) );
    } );

// Категории
Route::screen( 'categories', CategoryListScreen::class )
    ->name( 'platform.categories' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Категории' ), route( 'platform.categories' ) );
    } );

Route::screen( 'category/create', CategoryEditScreen::class )
    ->name( 'platform.category.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Категории' ), route( 'platform.categories' ) )
            ->push( __( 'Новая категория' ), route( 'platform.category.create' ) );
    } );

Route::screen( 'category/{category}/edit', CategoryEditScreen::class )
    ->name( 'platform.category.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Категории' ), route( 'platform.categories' ) )
            ->push( __( 'Редактирование категории' ) );
    } );

// Гео > Страны
Route::screen( 'geo/countries', CountryListScreen::class )
    ->name( 'platform.geo.countries' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Страны' ), route( 'platform.geo.countries' ) );
    } );

Route::screen( 'geo/countries/create', CountryEditScreen::class )
    ->name( 'platform.geo.country.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Страны' ), route( 'platform.geo.countries' ) )
            ->push( __( 'Новая страна' ), route( 'platform.geo.country.create' ) );
    } );

Route::screen( 'geo/countries/{country}/edit', CountryEditScreen::class )
    ->name( 'platform.geo.country.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Страны' ), route( 'platform.geo.countries' ) )
            ->push( __( 'Редактирование страны' ) );
    } );

// Гео > Города
Route::screen( 'geo/cities', CityListScreen::class )
    ->name( 'platform.geo.cities' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Города' ), route( 'platform.geo.cities' ) );
    } );

Route::screen( 'geo/city/create', CityEditScreen::class )
    ->name( 'platform.geo.city.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Города' ), route( 'platform.geo.cities' ) )
            ->push( __( 'Новый город' ), route( 'platform.geo.city.create' ) );
    } );

Route::screen( 'geo/city/{city}/edit', CityEditScreen::class )
    ->name( 'platform.geo.city.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Города' ), route( 'platform.geo.cities' ) )
            ->push( __( 'Редактирование города' ) );
    } );

// Гео > Метро
Route::screen( 'geo/metro', MetroLineListScreen::class )
    ->name( 'platform.geo.metro' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Метро' ), route( 'platform.geo.metro' ) );
    } );

Route::screen( 'geo/metro/create', MetroLineEditScreen::class )
    ->name( 'platform.geo.metro.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Метро' ), route( 'platform.geo.metro' ) )
            ->push( __( 'Новое метро' ), route( 'platform.geo.metro.create' ) );
    } );

Route::screen( 'geo/metro/{metro}/edit', MetroLineEditScreen::class )
    ->name( 'platform.geo.metro.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Метро' ), route( 'platform.geo.metro' ) )
            ->push( __( 'Редактирование метро' ) );
    } );

// Гео > Станции
Route::screen( 'geo/stations', MetroListScreen::class )
    ->name( 'platform.geo.stations' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Станции метро' ), route( 'platform.geo.stations' ) );
    } );

Route::screen( 'geo/station/create', MetroEditScreen::class )
    ->name( 'platform.geo.station.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Станции метро' ), route( 'platform.geo.stations' ) )
            ->push( __( 'Новая станция метро' ), route( 'platform.geo.station.create' ) );
    } );

Route::screen( 'geo/station/{station}/edit', MetroEditScreen::class )
    ->name( 'platform.geo.station.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Станции метро' ), route( 'platform.geo.stations' ) )
            ->push( __( 'Редактирование станции метро' ) );
    } );

// Гео > Города от пользователей
Route::screen( 'geo/user-cities', UserCityListScreen::class )
    ->name( 'platform.geo.user-cities' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Города от пользователей' ), route( 'platform.geo.user-cities' ) );
    } );

Route::screen( 'geo/user-city/{city}/edit', UserCityEditScreen::class )
    ->name( 'platform.geo.user-city.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Гео' ) )
            ->push( __( 'Города от пользователей' ), route( 'platform.geo.user-cities' ) )
            ->push( __( 'Редактирование город от пользователя' ) );
    } );

// Салоны
Route::screen( 'salons', SalonListScreen::class )
    ->name( 'platform.salons' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Салоны' ), route( 'platform.salons' ) );
    } );

Route::screen( 'salon/{salon}/edit', SalonEditScreen::class )
    ->name( 'platform.salon.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Салоны' ), route( 'platform.salons' ) )
            ->push( __( 'Редактирование салона' ) );
    } );

// Редактирование работ в салоне
Route::screen( 'salon/{salon}/album/{album}/edit', AlbumEditScreen::class )
    ->name( 'platform.salon.album.edit' );

// Отзывы
Route::screen( 'reviews', ReviewListScreen::class )
    ->name( 'platform.reviews' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Отзывы' ), route( 'platform.salons' ) );
    } );

Route::screen( 'review/{review}/edit', ReviewEditScreen::class )
    ->name( 'platform.review.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Отзывы' ), route( 'platform.reviews' ) )
            ->push( __( 'Редактирование отзыва' ) );
    } );

// Словари
Route::screen( 'dictionaries', DictionaryListScreen::class )
    ->name( 'platform.dictionaries' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Словари' ), route( 'platform.dictionaries' ) );
    } );

Route::screen( 'dictionary/{type}/edit', DictionaryEditScreen::class )
    ->name( 'platform.dictionary.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Словари' ), route( 'platform.dictionaries' ) )
            ->push( __( 'Редактирование словаря' ) );
    } );

// Поисковые страницы
Route::screen( 'search-pages', SearchPageListScreen::class )
    ->name( 'platform.search-pages' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Поисковые страницы' ), route( 'platform.search-pages' ) );
    } );

Route::screen( 'search-pages/{type}/create', SearchPageAddScreen::class )
    ->name( 'platform.search-pages.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Поисковые страницы' ), route( 'platform.search-pages' ) )
            ->push( __( 'Новая страница' ) );
    } );

Route::screen( 'search-pages/{page}/edit', SearchPageEditScreen::class )
    ->name( 'platform.search-pages.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Поисковые страницы' ), route( 'platform.search-pages' ) )
            ->push( __( 'Редактирование страницы' ) );
    } );

// Работы салонов
Route::screen( 'images', ImageListScreen::class )
    ->name( 'platform.images' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Работы салонов' ), route( 'platform.images' ) );
    } );

Route::screen( 'image/{id}/edit', ImageEditScreen::class )
    ->name( 'platform.images.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Работы салонов' ), route( 'platform.images' ) )
            ->push( __( 'Редактирование работы' ) );
    } );

// Landing page
Route::screen( 'landing-pages', LandingPageListScreen::class )
    ->name( 'platform.landing-pages' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Landing Page' ), route( 'platform.landing-pages' ) );
    } );

Route::screen( 'landing-pages/{type}/create', LandingPageAddScreen::class )
    ->name( 'platform.landing-pages.create' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Landing Page' ), route( 'platform.landing-pages' ) )
            ->push( __( 'Новый Landing Page' ) );
    } );

Route::screen( 'landing-pages/{page}/edit', LandingPageEditScreen::class )
    ->name( 'platform.landing-pages.edit' )
    ->breadcrumbs( function ( Trail $trail ) {
        return $trail
            ->parent( 'platform.index' )
            ->push( __( 'Landing Page' ), route( 'platform.landing-pages' ) )
            ->push( __( 'Редактирование Landing Page' ) );
    } );
