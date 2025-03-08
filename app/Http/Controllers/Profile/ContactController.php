<?php

namespace App\Http\Controllers\Profile;

use App\DTO\Contact\ContactDTO;
use App\Events\SalonCoordinatesChangedEvent;
use App\Http\Requests\Profile\UpdateContactRequest;
use App\Providers\RouteServiceProvider;
use App\Services\ContactService;
use App\Services\MetroService;
use Illuminate\Http\RedirectResponse;

class ContactController extends BaseProfileController
{
    /**
     * SalonController constructor.
     * @param ContactService $contact_service
     * @param MetroService $metro_service
     */
    public function __construct(
        private ContactService $contact_service,
        private MetroService $metro_service )
    {
        parent::__construct();
    }

    public function edit( int $contact_id )
    {
        $salon = $this->contact_service->findWithCityAndCountry( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.salon.edit', [
            'user'       => $this->auth_user,
            'contact_id' => $contact_id,
            'salon'      => $salon,
            'country'    => 1,
            'cities'     => $this->city_service->getByCountry( 1 ),
            'metro'      => $this->metro_service->getAllForLang(),
            'title'      => 'Редактирование контактов | ' . $salon->name . ' | Личный кабинет',
        ] );
    }

    /**
     * @param UpdateContactRequest $request
     * @param int $contact_id
     * @return RedirectResponse
     */
    public function update(UpdateContactRequest $request, int $contact_id ): RedirectResponse
    {
        $city_id = $this->city_service->getIdByName( $request->get( 'city' ) );
        if ( $city_id === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Такого города нет на сайте' ] );
        }

        $dto = ContactDTO::fromRequest( $request );
        $dto->city_id = $city_id;
        $contact = $this->contact_service->update( $contact_id, $dto );
        if ( $contact === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Не удалось обновить данные' ] );
        }

        $dto->id = $contact_id;
        SalonCoordinatesChangedEvent::dispatch( $dto );

        return redirect()->route( 'account.profile.contact.edit', [
            'contact_id' => $contact_id
        ] );
    }
}
