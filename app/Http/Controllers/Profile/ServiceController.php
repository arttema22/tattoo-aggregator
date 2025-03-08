<?php

namespace App\Http\Controllers\Profile;

use App\DTO\Service\ServiceDTO;
use App\Helpers\DTOHelper;
use App\Http\Requests\Profile\UpdateServicesRequest;
use App\Providers\RouteServiceProvider;
use App\Services\ContactService;
use App\Services\ServiceService;
use Illuminate\Http\RedirectResponse;

class ServiceController extends BaseProfileController
{
    /**
     * ServiceController constructor.
     * @param ContactService $contact_service
     * @param ServiceService $service_service
     */
    public function __construct(
        private ContactService $contact_service,
        private ServiceService $service_service )
    {
        parent::__construct();
    }

    /**
     * @param int $contact_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function edit( int $contact_id )
    {
        $salon = $this->contact_service->findWithServices( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.services.edit', [
            'user'            => $this->auth_user,
            'contact_id'      => $contact_id,
            'salon'           => $salon,
            'services'        => $this->service_service->getServicesByTypes( $salon->services ),
            'service_default' => $this->service_service->getDefaultServicesByTypes(),
            'title'           => 'Список оказываемых услуг | ' . $salon->name . ' | Личный кабинет',
        ] );
    }

    /**
     * @param UpdateServicesRequest $request
     * @param int $contact_id
     * @return RedirectResponse
     */
    public function update( UpdateServicesRequest $request, int $contact_id ): RedirectResponse
    {
        $salon = $this->contact_service->findWithServices( $contact_id );
        if ( $salon === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        if ( $this->service_service->sync(
                DTOHelper::getDTOCollection( ServiceDTO::class, $request ), $salon ) === false )
        {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка обновления данных' ] );
        }

        return redirect()->route( 'account.profile.services.edit', [
            'contact_id' => $contact_id
        ] );
    }
}
