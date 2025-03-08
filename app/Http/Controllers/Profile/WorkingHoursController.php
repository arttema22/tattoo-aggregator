<?php

namespace App\Http\Controllers\Profile;

use App\DTO\WorkingHours\WorkingHoursDTO;
use App\Helpers\DTOHelper;
use App\Http\Requests\Profile\UpdateWorkingHoursRequest;
use App\Providers\RouteServiceProvider;
use App\Services\ContactService;
use App\Services\WorkingHoursService;
use Illuminate\Http\RedirectResponse;

class WorkingHoursController extends BaseProfileController
{
    /**
     * WorkingHoursController constructor.
     * @param ContactService $contact_service
     * @param WorkingHoursService $working_hours_service
     */
    public function __construct(
        private ContactService $contact_service,
        private WorkingHoursService $working_hours_service )
    {
        parent::__construct();
    }

    public function edit( int $contact_id )
    {
        $salon = $this->contact_service->findWithWorkingHours( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.working-hours.edit', [
            'user'       => $this->auth_user,
            'contact_id' => $contact_id,
            'salon'      => $salon,
            'title'      => 'Часы работы | ' . $salon->name . ' | Личный кабинет',
        ] );
    }

    /**
     * @param UpdateWorkingHoursRequest $request
     * @param int $contact_id
     * @return RedirectResponse
     */
    public function update( UpdateWorkingHoursRequest $request, int $contact_id ): RedirectResponse
    {
        $salon = $this->contact_service->findWithWorkingHours( $contact_id );
        if ( $salon === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        if ( $this->working_hours_service->sync(
                DTOHelper::getDTOCollection( WorkingHoursDTO::class, $request ), $salon ) === false )
        {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка обновления данных' ] );
        }

        return redirect()->route( 'account.profile.working-hours.edit', [
            'contact_id' => $contact_id
        ] );
    }
}
