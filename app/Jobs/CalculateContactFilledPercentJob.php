<?php

namespace App\Jobs;

use App\DTO\Contact\ContactDTO;
use App\Enums\ContactFilledCriteriaSubtypes;
use App\Enums\ContactFilledCriteriaTypes;
use App\Enums\ModelsRelations\ContactRelations;
use App\Enums\WorkApproved;
use App\Filters\AlbumFilter;
use App\Filters\ContactFilledCriteriaFilter;
use App\Helpers\WeekdayHelper;
use App\Models\Contact;
use App\Models\ContactFilledCriteria;
use App\Models\WorkingHours;
use App\Services\AlbumService;
use App\Services\ContactFilledCriteriaService;
use App\Services\ContactService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CalculateContactFilledPercentJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $contact_id
    ) {}

    public function uniqueId(): string
    {
        return self::class  . '-' . $this->contact_id;
    }

    public function handle(
        ContactFilledCriteriaService $contact_filled_criteria_service,
        ContactFilledCriteriaFilter $contact_filled_criteria_filter,
        ContactService $contact_service
    ): void {
        $contact = $contact_service->find( $this->contact_id, [
            ContactRelations::COUNTRY,
            ContactRelations::CITY,
            ContactRelations::COVER,
            ContactRelations::SERVICES,
            ContactRelations::ADDITIONAL_SERVICES,
            ContactRelations::SOCIAL_NETWORKS,
        ] );
        if ( $contact === null ) {
            return;
        }

        $criteria_types =
            $contact_filled_criteria_service
                ->search( $contact_filled_criteria_filter )
                ->groupBy( 'type' );

        $total_percent = $criteria_types->reduce( fn ( $percent, Collection $criteria_type_list, int $criteria_type ) =>
            $percent += match ($criteria_type) {
                ContactFilledCriteriaTypes::GENERAL            => $this->calculateGeneralPercent( $contact, $criteria_type_list ),
                ContactFilledCriteriaTypes::SALON              => $this->calculateSalonPercent( $contact, $criteria_type_list ),
                ContactFilledCriteriaTypes::WORK_GALLERY       => $this->calculateWorkGalleryPercent( $contact, $criteria_type_list ),
                ContactFilledCriteriaTypes::SERVICE            => $this->calculateServicePercent( $contact, $criteria_type_list ),
                ContactFilledCriteriaTypes::ADDITIONAL_SERVICE => $this->calculateAdditionalServicePercent( $contact, $criteria_type_list ),
                ContactFilledCriteriaTypes::SOCIAL_NETWORK     => $this->calculateSocialNetworkPercent( $contact, $criteria_type_list ),
                ContactFilledCriteriaTypes::WORKING_HOURS      => $this->calculateWorkingHoursPercent( $contact, $criteria_type_list ),
                default                                        => 0
            }
        );

        $dto = app()->make( ContactDTO::class );
        $dto->filled_percent = $total_percent;
        Contact::withoutEvents( static fn () => $contact_service->update( $contact->id, $dto ) );
    }

    private function calculateGeneralPercent( Contact $contact, Collection $criteria_type_list ): int
    {
        $percent = 0;
        /** @var ContactFilledCriteria $criteria */
        foreach ( $criteria_type_list as $criteria ) {
            $percent += match ($criteria->subtype) {
                ContactFilledCriteriaSubtypes::GENERAL_NAME        => $contact->name ? $criteria->percent : 0,
                ContactFilledCriteriaSubtypes::GENERAL_DESCRIPTION => $contact->description ? $criteria->percent : 0,
                ContactFilledCriteriaSubtypes::GENERAL_COVER       => $contact->cover ? $criteria->percent : 0,
                default                                            => 0,
            };
        }

        return $percent;
    }

    private function calculateSalonPercent( Contact $contact, Collection $criteria_type_list ): int
    {
        $percent = 0;
        /** @var ContactFilledCriteria $criteria */
        foreach ( $criteria_type_list as $criteria ) {
            switch ( $criteria->subtype ) {
                case ContactFilledCriteriaSubtypes::SALON_ADDRESS:
                    if ( $contact->country && $contact->city && $contact->address ) {
                        $percent += $criteria->percent;
                    }
                    break;

                case ContactFilledCriteriaSubtypes::SALON_EMAIL:
                    $percent += $contact->email ? $criteria->percent : 0;
                    break;

                case ContactFilledCriteriaSubtypes::SALON_PHONE:
                    $percent += $contact->phone ? $criteria->percent : 0;
                    break;

                case ContactFilledCriteriaSubtypes::SALON_COORDINATES:
                    if ( $contact->city &&
                         $contact->city->lat !== $contact->lat &&
                         $contact->city->lon !== $contact->lon
                    ) {
                        $percent += $criteria->percent;
                    }
                    break;
            }
        }

        return $percent;
    }

    private function calculateWorkGalleryPercent( Contact $contact, Collection $criteria_type_list ): int
    {
        $album_service = app()->make( AlbumService::class );
        $album_filter = app()->make( AlbumFilter::class );
        $album_filter->setCustomFields( [ 'contact' => $contact->id ] );

        return
            $this->getPercentByValue(
                $album_service
                    ->searchWithFiles( $album_filter )
                    ->pluck( 'files.*.fileInfo' )
                    ->flatten()
                    ->where( 'is_approved', WorkApproved::APPROVE )
                    ->count(),
                $criteria_type_list
            );
    }

    private function calculateServicePercent( Contact $contact, Collection $criteria_type_list ): int
    {
        return $this->getPercentByValue( $contact->services->count(), $criteria_type_list );
    }

    private function calculateAdditionalServicePercent( Contact $contact, Collection $criteria_type_list ): int
    {
        return $this->getPercentByValue( $contact->additionalServices->count(), $criteria_type_list );
    }

    private function calculateSocialNetworkPercent( Contact $contact, Collection $criteria_type_list ): int
    {
        return $this->getPercentByValue( $contact->socialNetworks->count(), $criteria_type_list );
    }

    private function getPercentByValue( int $count, Collection $criteria_type_list ): int
    {
        /** @var ContactFilledCriteria|null $criteria */
        $criteria =
            $criteria_type_list
                ->where( 'value', '<=', $count )
                ->sortByDesc( 'value' )
                ->first();

        return $criteria->percent ?? 0;
    }

    private function calculateWorkingHoursPercent( Contact $contact, Collection $criteria_type_list ): int
    {
        $filled_working_hours_days = $contact->workingHours->filter(
            fn ( WorkingHours $day ) => ( $day->start !== null && $day->end !== null ) || $day->is_weekend || $day->is_nonstop
        )->count();

        return $filled_working_hours_days === WeekdayHelper::DAYS_OF_WEEK ? $criteria_type_list->first()?->percent : 0;
    }
}
