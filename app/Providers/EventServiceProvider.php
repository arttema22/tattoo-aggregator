<?php

namespace App\Providers;

use App\Events\SalonCoordinatesChangedEvent;
use App\Events\UploadedImageEvent;
use App\Events\VideoAddEvent;
use App\Events\VideoReParseEvent;
use App\Listeners\ProcessImageListener;
use App\Listeners\SalonCoordinatesChangedListener;
use App\Listeners\VideoAddListener;
use App\Models\AdditionalService;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Dictionaries\Dictionary;
use App\Models\FileInfo;
use App\Models\Service;
use App\Models\SocialNetwork;
use App\Models\WorkingHours;
use App\Observers\AdditionalServiceObserver;
use App\Observers\CategoryObserver;
use App\Observers\CityObserver;
use App\Observers\ContactObserver;
use App\Observers\DictionaryObserver;
use App\Observers\FileInfoObserver;
use App\Observers\ServiceObserver;
use App\Observers\SocialNetworkObserver;
use App\Observers\WorkingHoursObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        UploadedImageEvent::class => [
            ProcessImageListener::class
        ],

        VideoAddEvent::class => [
            VideoAddListener::class
        ],

        VideoReParseEvent::class => [
            VideoAddListener::class
        ],

        SalonCoordinatesChangedEvent::class => [
            SalonCoordinatesChangedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Dictionary::observe( DictionaryObserver::class );
        City::observe( CityObserver::class );
        Category::observe( CategoryObserver::class );
        Contact::observe( ContactObserver::class );
        FileInfo::observe( FileInfoObserver::class );
        Service::observe( ServiceObserver::class );
        AdditionalService::observe( AdditionalServiceObserver::class );
        SocialNetwork::observe( SocialNetworkObserver::class );
        WorkingHours::observe( WorkingHoursObserver::class );
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
