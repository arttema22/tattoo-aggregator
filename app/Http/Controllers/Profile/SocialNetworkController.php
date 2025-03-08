<?php

namespace App\Http\Controllers\Profile;

use App\DTO\SocialNetwork\SocialNetworkDTO;
use App\Helpers\DTOHelper;
use App\Http\Requests\Profile\UpdateSocialNetworksRequest;
use App\Providers\RouteServiceProvider;
use App\Services\ContactService;
use App\Services\SocialNetworkNameService;
use App\Services\SocialNetworkService;
use Illuminate\Http\RedirectResponse;

class SocialNetworkController extends BaseProfileController
{
    /**
     * SocialNetworkController constructor.
     * @param ContactService $contact_service
     * @param SocialNetworkService $social_network_service
     * @param SocialNetworkNameService $social_network_name_service
     */
    public function __construct(
        private ContactService $contact_service,
        private SocialNetworkService $social_network_service,
        private SocialNetworkNameService $social_network_name_service )
    {
        parent::__construct();
    }

    public function edit( int $contact_id )
    {
        $salon = $this->contact_service->findWithSocialNetworks( $contact_id );
        if ( $salon === null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        return view( 'account.profile.social-networks.edit', [
            'user'                => $this->auth_user,
            'contact_id'          => $contact_id,
            'salon'               => $salon,
            'social_network_name' => $this->social_network_name_service->allEnabled(),
            'title'               => 'Список социальных сетей | ' . $salon->name . ' | Личный кабинет',
        ] );
    }

    /**
     * @param UpdateSocialNetworksRequest $request
     * @param int $contact_id
     * @return RedirectResponse
     */
    public function update( UpdateSocialNetworksRequest $request, int $contact_id ): RedirectResponse
    {
        $salon = $this->contact_service->findWithSocialNetworks( $contact_id );
        if ( $salon === null ) {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка получения данных салона' ] );
        }

        if ( $this->social_network_service->sync(
                DTOHelper::getDTOCollection( SocialNetworkDTO::class, $request ), $salon ) === false )
        {
            return back()->withInput()->withErrors( [ 'message' => 'Ошибка обновления данных' ] );
        }

        return redirect()->route( 'account.profile.social-networks.edit', [
            'contact_id' => $contact_id
        ] );
    }
}
