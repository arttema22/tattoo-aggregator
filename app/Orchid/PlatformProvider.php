<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Enums\ReviewApprove;
use App\Enums\WorkApproved;
use App\Models\File;
use App\Models\Review;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot( Dashboard $dashboard ) : void
    {
        parent::boot( $dashboard );
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make( 'Блог' )
                ->icon( 'note' )
                ->list( [
                    Menu::make( __( 'Статьи' ) )
                        ->route( 'platform.articles' )
                        ->permission( 'platform.articles' ),

                    Menu::make( __( 'Категории' ) )
                        ->route( 'platform.categories' )
                        ->permission( 'platform.category' ),
                ] ),

            Menu::make( __( 'Салоны' ) )
                ->icon( 'briefcase' )
                ->route( 'platform.salons' )
                ->permission( 'platform.salons' )
                ->title( __( 'Салоны' ) ),

            Menu::make( __( 'Работы' ) )
                ->icon( 'picture' )
                ->route( 'platform.images' )
                ->permission( 'platform.images' )
                ->badge( function () {
                    return File::where( 'fileable_type', '=', 'App\\Models\\Album' )
                        ->whereHas( 'fileInfo', function ( $query ) {
                            $query->where( 'is_approved', '=', WorkApproved::WAIT );
                        } )->count();
                } ),

            Menu::make( __( 'Отзывы' ) )
                ->icon( 'bubbles' )
                ->route( 'platform.reviews' )
                ->permission( 'platform.reviews' )
                ->badge( function () {
                    return Review::where( 'is_approved', '=', ReviewApprove::NO )->count();
                } ),

            Menu::make( 'Гео' )
                ->icon( 'globe' )
                ->list( [
                    Menu::make( __( 'Страны' ) )
                        ->route( 'platform.geo.countries' )
                        ->permission( 'platform.geo.countries' ),

                    Menu::make( __( 'Города' ) )
                        ->route( 'platform.geo.cities' )
                        ->permission( 'platform.geo.cities' ),

                    /*Menu::make( __( 'Пользовательские города' ) )
                        ->route( 'platform.geo.user-cities' )
                        ->permission( 'platform.geo.user-cities' ),*/

                    Menu::make( __( 'Метро' ) )
                        ->route( 'platform.geo.metro' )
                        ->permission( 'platform.geo.metro' ),

                    Menu::make( __( 'Станции метро' ) )
                        ->route( 'platform.geo.stations' )
                        ->permission( 'platform.geo.stations' ),
                ] )
                ->title( __( 'Настройки' ) ),

            Menu::make( __( 'Словари' ) )
                ->icon( 'book-open' )
                ->route( 'platform.dictionaries' )
                ->permission( 'platform.dictionaries' ),

            Menu::make( __( 'Поисковые страницы' ) )
                ->icon( 'magnifier' )
                ->route( 'platform.search-pages' )
                ->permission( 'platform.search-pages' ),

            Menu::make( __( 'Landing Page' ) )
                ->icon( 'rocket' )
                ->route( 'platform.landing-pages' )
                ->permission( 'platform.landing-pages' ),

            Menu::make( __( 'Users' ) )
                ->icon( 'user' )
                ->route( 'platform.systems.users' )
                ->permission( 'platform.systems.users' )
                ->title( __( 'Access rights' ) ),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make( 'Profile' )
                ->route( 'platform.profile' )
                ->icon( 'user' ),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group( __( 'System' ) )
                ->addPermission( 'platform.systems.users', __( 'Users' ) ),

            ItemPermission::group( __( 'Блог' ) )
                ->addPermission( 'platform.articles', __( 'Статьи' ) )
                ->addPermission( 'platform.category', __( 'Категории' ) ),

            ItemPermission::group( __( 'Гео' ) )
                ->addPermission( 'platform.geo.countries', __( 'Страны' ) )
                ->addPermission( 'platform.geo.cities', __( 'Города' ) )
                ->addPermission( 'platform.geo.metro', __( 'Метро' ) )
                ->addPermission( 'platform.geo.stations', __( 'Станции метро' ) )
                ->addPermission( 'platform.geo.user-cities', __( 'Города от пользователей' ) ),

            ItemPermission::group( __( 'Салоны' ) )
                ->addPermission( 'platform.salons', __( 'Салоны' ) )
                ->addPermission( 'platform.images', __( 'Работы' ) )
                ->addPermission( 'platform.reviews', __( 'Отзывы' ) ),

            ItemPermission::group( __( 'Словари' ) )
                ->addPermission( 'platform.dictionaries', __( 'Словари' ) ),

            ItemPermission::group( __( 'Поисковые страницы' ) )
                ->addPermission( 'platform.search-pages', __( 'Поисковые страницы' ) ),

            ItemPermission::group( __( 'Landing page' ) )
                ->addPermission( 'platform.landing-pages', __( 'Landing page' ) ),
        ];
    }
}
