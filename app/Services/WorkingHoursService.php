<?php

namespace App\Services;

use App\DTO\WorkingHours\WorkingHoursDTO;
use App\Filters\WorkingHoursFilter;
use App\Helpers\WeekdayHelper;
use App\Models\Contact;
use App\Models\WorkingHours;
use App\Repositories\WorkingHoursRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;

class WorkingHoursService
{
    private WorkingHoursRepository $repository;

    /**
     * WorkingHoursService constructor.
     * @param WorkingHoursRepository $repository
     */
    public function __construct( WorkingHoursRepository $repository )
    {
        $this->repository = $repository;
    }

    /**
     * @param WorkingHoursDTO $dto
     * @return WorkingHoursDTO
     */
    protected function correctDTO( WorkingHoursDTO $dto ): WorkingHoursDTO
    {
        if ( empty( $dto->start ) ||
             empty( $dto->end ) ||
             !empty( $dto->is_weekend ) ||
             !empty( $dto->is_nonstop ) )
        {
            // если не указано какое-либо время, или если указано что салон работает круглосуточно, или у него выходной.
            // то необходимо удалить время работы и оставить пометку о типе работы в текущий день
            $dto->start = null;
            $dto->end   = null;

            $dto->is_nonstop ??= false;

            // либо салон работает круглосуточно, либо это выходной
            $dto->is_weekend = ( $dto->is_weekend ?? false ) & !( $dto->is_nonstop );
        }

        return $dto;
    }

    /**
     * @param WorkingHoursDTO $dto
     * @param Contact $contact
     * @return WorkingHours|null
     */
    public function create( WorkingHoursDTO $dto, Contact $contact ): ?WorkingHours
    {
        $dto->contact_id = $contact->id;
        $dto->profile_id = $contact->profile_id;

        return $this->repository->store( $this->correctDTO( $dto ) );
    }

    /**
     * @param int $id
     * @param WorkingHoursDTO $dto
     * @return WorkingHours|null
     */
    public function update( int $id, WorkingHoursDTO $dto ): ?WorkingHours
    {
        return $this->repository->update( $id, $this->correctDTO( $dto ) );
    }

    /**
     * @param WorkingHoursDTO $dto
     * @param Contact $contact
     * @return WorkingHours|null
     */
    public function updateOrCreate( WorkingHoursDTO $dto, Contact $contact ): ?WorkingHours
    {
        if ( isset( $dto->id ) ) {
            $id = $dto->id;
            unset( $dto->id );

            return $this->update( $id, $dto );
        }

        return $this->create( $dto, $contact );
    }

    /**
     * @param WorkingHoursFilter $working_hours_filter
     * @return Collection|LengthAwarePaginator
     */
    public function get( WorkingHoursFilter $working_hours_filter )
    {
        return $this->repository->search( $working_hours_filter );
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete( int $id ): bool
    {
        return $this->repository->delete( $id );
    }

    /**
     * @param \Illuminate\Support\Collection $collection_dto
     * @param Contact $contact
     * @return bool
     */
    public function sync( \Illuminate\Support\Collection $collection_dto, Contact $contact ): bool
    {
        $contact_models_id = $contact->workingHours->pluck( 'id' );
        $dto_models_id = $collection_dto->whereNotNull( 'id' )->pluck( 'id' );
        if ( $dto_models_id->diff( $contact_models_id )->isNotEmpty() ) {
            // если в переданных данных есть идентификаторы модели не относящиеся к переданному контакту,
            // то пришли некорректные данные, и ничего не синхронизируем
            return false;
        }

        // удаляем данные, по которым не пришло идентификаторов
        $contact_models_id
            ->diff( $dto_models_id )
            ->each( fn( $id ) => $this->delete( $id ) );

        $collection_dto->each( fn( $dto ) => $this->updateOrCreate( $dto, $contact ) );
        return true;
    }

    public function createWorkingHoursForContact( Contact $contact ): bool
    {
        $result = true;

        /** @var WorkingHoursDTO $dto */
        $dto = App::make( WorkingHoursDTO::class );
        foreach ( WeekdayHelper::getAllWeekDays() as $day ) {
            $dto->day = $day;

            if ( $this->create( $dto, $contact ) === false ) {
                $result = false;
            }
        }

        return $result;
    }
}
