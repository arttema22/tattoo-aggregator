<?php

namespace App\Http\Controllers\Profile;

use App\DTO\Contact\ContactDTO;
use App\Filters\ContactFilter;
use App\Http\Requests\Profile\CreateSalonRequest;
use App\Services\AlbumService;
use App\Services\ContactService;
use App\Services\WorkingHoursService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class SalonController extends BaseProfileController
{
    /**
     * SalonController constructor.
     * @param ContactService $contact_service
     * @param AlbumService $album_service
     * @param WorkingHoursService $working_hours_service
     */
    public function __construct(
        private ContactService $contact_service,
        private AlbumService $album_service,
        private WorkingHoursService $working_hours_service
    ) {
        parent::__construct();
    }

    public function index()
    {
        $contact_filter = app()->make( ContactFilter::class );
        $contact_filter->setCustomFields( [ 'profile_id' => $this->auth_user->profile->id ] );

        return view( 'account.profile.salon.index', [
            'user'   => $this->auth_user,
            'salons' => $this->contact_service->search( $contact_filter ),
            'title'  => 'Салоны | Личный кабинет',
        ] );
    }

    public function create()
    {
        return view( 'account.profile.salon.create', [
            'user'  => $this->auth_user,
            'title' => 'Добавить новый салон | Личный кабинет',
        ] );
    }

    /**
     * @param CreateSalonRequest $request
     * @return RedirectResponse
     */
    public function store( CreateSalonRequest $request ): RedirectResponse
    {
        $contact = $this->contact_service->create( ContactDTO::fromRequest( $request ), $this->auth_user->profile );
        if ( $contact === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось добавить салон' ] );
        }

        if ( $this->album_service->createAlbumsForContact( $contact ) === false ) {
            Log::warning( 'Ошибка создания альбомов для салона мастера', [
                'user'    => $this->auth_user,
                'contact' => $contact
            ] );
        }

        if ( $this->working_hours_service->createWorkingHoursForContact( $contact ) === false ) {
            Log::warning( 'Ошибка создания расписания для салона', [
                'user'    => $this->auth_user,
                'contact' => $contact
            ] );
        }

        return redirect()->route( 'account.profile.contact.edit', [ 'contact_id' => $contact->id ] );
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete( int $id ): RedirectResponse
    {
        if ( $this->contact_service->delete( $id ) === false ) {
            return redirect()
                ->route( 'account.profile.salons.index' )
                ->withErrors( [ 'message' => 'Не удалось удалить салон' ] );
        }

        return redirect()->route( 'account.profile.salons.index' );
    }
}

