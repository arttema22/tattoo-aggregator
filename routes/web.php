<?php

use App\Http\Controllers\ArticleController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\MasterRoutesForbidden;
use App\Http\Middleware\VerifyUserSalon;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

// Главная страница
Route::get( '/', [ App\Http\Controllers\IndexController::class, 'index' ] )->name( 'index' );

// Поиск по фильтрам
Route::get( '/tattoo/{filter?}', [ App\Http\Controllers\SearchController::class, 'searchTattoo' ] )
    ->name( 'search.tattoo' );
Route::get( '/piercing/{filter?}', [ App\Http\Controllers\SearchController::class, 'searchPiercing' ] )
    ->name( 'search.piercing' );
Route::get( '/tatuaje/{filter?}', [ App\Http\Controllers\SearchController::class, 'searchTatuaje' ] )
    ->name( 'search.tatuaje' );
Route::post( '/{city}/tattoo', [ App\Http\Controllers\SearchController::class, 'searchCityTattoo' ] )
    ->name( 'search.city.tattoo' );
Route::post( '/{city}/piercing', [ App\Http\Controllers\SearchController::class, 'searchCityPiercing' ] )
    ->name( 'search.city.piercing' );
Route::post( '/{city}/tatuaje', [ App\Http\Controllers\SearchController::class, 'searchCityTatuaje' ] )
    ->name( 'search.city.tatuaje' );

// Блог, Новости,
Route::get( '/blog', [ App\Http\Controllers\ArticleController::class, 'index' ] )->name( 'article.all' );
Route::get( '/category/{alias}/', [ App\Http\Controllers\ArticleController::class, 'getByCategory' ] )->name( 'article.category.all' );

// Каталог салонов
Route::get( '/listings', [ App\Http\Controllers\CatalogController::class, 'index' ] )->name( 'catalog.index' );
Route::get( '/listings/{city}', [ App\Http\Controllers\CatalogController::class, 'getByCity' ] )->name( 'catalog.city' );

// Отдельный салон
Route::get( '/place/{alias}', [ App\Http\Controllers\SalonController::class, 'index' ] )->name( 'salon.index' );

// Отдельная страница для работы
Route::get( '/work/{salon}/{album_id}/{file_id}/short', [ App\Http\Controllers\WorkController::class, 'short' ] )->name( 'work.short' );
Route::get( '/work/{salon}/{album_id}/{file_id}', [ App\Http\Controllers\WorkController::class, 'full' ] )->name( 'work.full' );

// Отдельная страница для видео
Route::get( '/video/{id}', [ App\Http\Controllers\VideoController::class, 'show' ] )->name( 'video.show' );

// Изменения профиля
Route::prefix( '/account/profile' )
    ->name( 'account.profile.' )
    ->middleware([ Authenticate::class, EnsureEmailIsVerified::class ])
    ->group( function () {
        // главная страница профиля
        Route::get( '/', [ App\Http\Controllers\Profile\ProfileController::class, 'index' ] )->name( 'index' );

        // настройки
        Route::get( '/settings', [ App\Http\Controllers\Profile\AccountSettingsController::class, 'edit'] )->name( 'settings.edit' );
        Route::post( '/settings', [ App\Http\Controllers\Profile\AccountSettingsController::class, 'update' ] )->name( 'settings.update' );

        // салоны
        Route::middleware( MasterRoutesForbidden::class )->group( function() {
            Route::get( '/salons', [ App\Http\Controllers\Profile\SalonController::class, 'index' ] )->name( 'salons.index' );
            Route::get( '/salons/add', [ App\Http\Controllers\Profile\SalonController::class, 'create' ] )->name( 'salons.create' );
            Route::post( '/salons/store', [ App\Http\Controllers\Profile\SalonController::class, 'store' ] )->name( 'salons.store' );
            Route::get( '/salons/{contact_id}/delete', [ App\Http\Controllers\Profile\SalonController::class, 'delete' ] )->name( 'salons.delete' );
        } );

        // маршруты относящиеся к салону
        Route::prefix( '/{contact_id}' )->middleware( VerifyUserSalon::class )->group( function () {
            // общее
            Route::get( '/general', [ App\Http\Controllers\Profile\GeneralSettingsController::class, 'edit'] )->name( 'general.edit' );
            Route::post( '/general', [ App\Http\Controllers\Profile\GeneralSettingsController::class, 'update' ] )->name( 'general.update' );
            Route::post( '/general/alias', [ App\Http\Controllers\Profile\GeneralSettingsController::class, 'checkAlias' ] )->name( 'general.check_alias' );

            // галерея работ
            Route::prefix('/work-gallery/{type}')->group( function() {
                Route::get( '/', [ App\Http\Controllers\Profile\WorkGalleryController::class, 'index'] )->name( 'work-gallery.index' );
                Route::get( '/create', [ App\Http\Controllers\Profile\WorkGalleryController::class, 'create'] )->name( 'work-gallery.create' );
                Route::get( '/edit/{id}', [ App\Http\Controllers\Profile\WorkGalleryController::class, 'edit'] )->name( 'work-gallery.edit' );
                Route::post( '/', [ App\Http\Controllers\Profile\WorkGalleryController::class, 'store'] )->name( 'work-gallery.store' );
                Route::post( '/update/{id}', [ App\Http\Controllers\Profile\WorkGalleryController::class, 'update' ] )->name( 'work-gallery.update');
                Route::get( '/delete/{id}', [ App\Http\Controllers\Profile\WorkGalleryController::class, 'delete'] )->name( 'work-gallery.delete' );
            } );

            // услуги
            Route::get( '/services', [ App\Http\Controllers\Profile\ServiceController::class, 'edit'] )->name( 'services.edit' );
            Route::post( '/services', [ App\Http\Controllers\Profile\ServiceController::class, 'update' ] )->name( 'services.update' );

            // дополнительные услуги
            Route::get( '/additional-services', [ App\Http\Controllers\Profile\AdditionalServiceController::class, 'edit'] )
                ->name( 'additional-services.edit' );
            Route::post( '/additional-services', [ App\Http\Controllers\Profile\AdditionalServiceController::class, 'update' ] )
                ->name( 'additional-services.update' );

            // видео
            Route::get( '/video-gallery', [ App\Http\Controllers\Profile\VideoGalleryController::class, 'edit'] )
                ->name( 'video-gallery.edit' );
            Route::post( '/video-gallery', [ App\Http\Controllers\Profile\VideoGalleryController::class, 'add' ] )
                ->name( 'video-gallery.add' );
            Route::get( '/video-gallery/{video}/delete', [ App\Http\Controllers\Profile\VideoGalleryController::class, 'remove'] )
                ->name( 'video-gallery.remove' );

            // контакты
            Route::get( '/contact', [ App\Http\Controllers\Profile\ContactController::class, 'edit'] )->name( 'contact.edit' );
            Route::post( '/contact', [ App\Http\Controllers\Profile\ContactController::class, 'update' ] )->name( 'contact.update' );

            // социальные сети
            Route::get( '/social-networks', [ App\Http\Controllers\Profile\SocialNetworkController::class, 'edit'] )
                ->name( 'social-networks.edit' );
            Route::post( '/social-networks', [ App\Http\Controllers\Profile\SocialNetworkController::class, 'update' ] )
                ->name( 'social-networks.update' );

            // часы работы
            Route::get( '/working-hours', [ App\Http\Controllers\Profile\WorkingHoursController::class, 'edit'] )
                ->name( 'working-hours.edit' );
            Route::post( '/working-hours', [ App\Http\Controllers\Profile\WorkingHoursController::class, 'update' ] )
                ->name( 'working-hours.update' );
        } );
    } );

Route::get( '/logout', [ App\Http\Controllers\Auth\LoginController::class, 'logoutLink' ] )->name( 'logout' );

// Отдельные статьи
Route::get( '/{alias}', [ App\Http\Controllers\ArticleController::class, 'showByAlias' ] )->name( 'article.get' );

// Посадочные страницы
Route::get( '/{city}/{landing_page_name}', [ App\Http\Controllers\LandingPageController::class, 'index' ] )->name( 'landing-page.index' );

// Сохранение фидбека
Route::post( '/feedback', [ App\Http\Controllers\FeedbackController::class, 'store' ] )->name( 'feedback.store' );


Route::get( '/articles/search', 'App\Http\Controllers\ArticleController@search' )->name( 'article.search' );
Route::put( '/articles/{id}/publish', 'App\Http\Controllers\ArticleController@publish' )->name( 'article.publish' );
Route::resource( 'articles', ArticleController::class );

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout/lite', [App\Http\Controllers\HomeController::class, 'logoutSwitchUser'])->name('logout.switch-user');

