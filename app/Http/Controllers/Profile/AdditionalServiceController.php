<?php

namespace App\Http\Controllers\Profile;

use App\DTO\AdditionalService\AdditionalServiceDTO;
use App\Helpers\DTOHelper;
use App\Http\Requests\Profile\UpdateAdditionalServicesRequest;
use App\Providers\RouteServiceProvider;
use App\Services\AdditionalServiceNameService;
use App\Services\AdditionalServiceService;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;

class AdditionalServiceController extends BaseProfileController
{
    /**
     * AdditionalServiceController constructor.
     * @param ContactService $contact_service
     * @param AdditionalServiceService $additional_service_service
     * @param AdditionalServiceNameService $additional_service_name_service
     */
    public function __construct(
        private ContactService $contact_service,
        private AdditionalServiceService $additional_service_service,
        private AdditionalServiceNameService $additional_service_name_service )
    {
        parent::__construct();
    }

    public function edit( int $contact_id )
    {
        $salon = $this->contact_service->findWithAdditionalServices( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.additional-services.edit', [
            'user'                    => $this->auth_user,
            'contact_id'              => $contact_id,
            'salon'                   => $salon,
            'additional_service_name' => $this->additional_service_name_service->all(),
            'title'                   => 'Список дополнительных услуг | ' . $salon->name . ' | Личный кабинет',
        ] );
    }

    /**
     * @param UpdateAdditionalServicesRequest $request
     * @param int $contact_id
     * @return RedirectResponse
     */
    public function update( UpdateAdditionalServicesRequest $request, int $contact_id ): RedirectResponse
    {
        $salon = $this->contact_service->findWithAdditionalServices( $contact_id );
        if ( $salon === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        if ( $this->additional_service_service->sync(
                DTOHelper::getDTOCollection( AdditionalServiceDTO::class, $request ), $salon ) === false )
        {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка обновления данных' ] );
        }

        return redirect()->route( 'account.profile.additional-services.edit', [
            'contact_id' => $contact_id
        ] );
    }
}
