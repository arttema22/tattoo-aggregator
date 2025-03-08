<?php

namespace App\Jobs;

use App\DTO\Contact\ContactDTO;
use App\Filters\ContactFilter;
use App\Services\SalonDistanceService;
use App\Services\ContactService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CalculateDistanceBetweenSalonsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private ContactDTO $contact_dto
    ) {}

    public function handle(
        ContactService $contact_service,
        SalonDistanceService $salon_distance_service ): void
    {
        /** @var ContactFilter $contact_filter */
        $contact_filter = App::make( ContactFilter::class );
        $contact_filter->setCustomFields( [
            'city_id' => $this->contact_dto->city_id
        ] );

        $city_salons = $contact_service->search( $contact_filter );
        if ( $city_salons->isEmpty() ) {
            Log::warning( 'Не найдено ни одного салона для города', [ 'city_id' => $this->contact_dto->city_id ] );
            return;
        }

        $salon_distance_service->updateForCitySalons( $city_salons, $this->contact_dto );
    }
}
