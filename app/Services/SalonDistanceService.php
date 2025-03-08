<?php

namespace App\Services;

use App\DTO\Contact\ContactDTO;
use App\Enums\ModelsRelations\SalonDistanceRelations;
use App\Filters\SalonDistanceFilter;
use App\Helpers\CoordinatesHelper;
use App\Models\Contact;
use App\Repositories\SalonDistanceRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class SalonDistanceService
{
    /**
     * SalonDistanceService constructor.
     * @param SalonDistanceRepository $repository
     */
    public function __construct( private SalonDistanceRepository $repository )
    {}

    public function getSalonsNearby( int $id, int $distance )
    {
        /** @var SalonDistanceFilter $filter */
        $filter = App::make( SalonDistanceFilter::class );
        $filter->setCustomFields( [
            'salon_id' => $id,
            'distance' => $distance
        ] );

        return $this->repository->search( $filter, [ SalonDistanceRelations::SALON_NEARBY_WITH_COVER ] );
    }

    public function updateOrCreate( Collection $data ): void
    {
        $this->repository->updateOrCreate( $data );
    }

    public function updateForCitySalons( Collection $city_salons, ContactDTO $salon_dto ): void
    {
        $updateData = [];

        /** @var Contact $salon */
        foreach ( $city_salons as $salon ) {
            if ( $salon->id === $salon_dto->id ) {
                continue;
            }

            $distance = CoordinatesHelper::vincentyGreatCircleDistance(
                $salon_dto->lat,
                $salon_dto->lon,
                $salon->lat,
                $salon->lon );

            $updateData[] = [
                'salon_id' => $salon_dto->id,
                'salon_nearby_id' => $salon->id,
                'distance' => $distance
            ];

            $updateData[] = [
                'salon_id' => $salon->id,
                'salon_nearby_id' => $salon_dto->id,
                'distance' => $distance
            ];
        }

        $this->updateOrCreate( collect( $updateData ) );
    }
}