<?php

namespace App\Http\Controllers\Profile;

use App\DTO\User\ChangePasswordDTO;
use App\Enums\ProfileTypes;
use App\Http\Requests\Profile\ChangeUserPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class AccountSettingsController extends BaseProfileController
{
    /**
     * AccountSettingsController constructor.
     * @param UserService $user_service
     */
    public function __construct(
        private UserService $user_service
    )
    {
        parent::__construct();
    }

    public function edit()
    {
        $data = [ 'user' => $this->auth_user ];

        // возвращаем идентификатор салона только для мастера, для отрисовки меню
        if ( $this->auth_user->profile->type === ProfileTypes::MASTER ) {
            $data[ 'contact_id' ] = $this->auth_user->profile->contacts->first()->id;
        }

        $data[ 'title' ] = 'Настройки аккаунта | Личный кабинет';

        return view( 'account.profile.settings.edit', $data );
    }

    /**
     * @param ChangeUserPasswordRequest $request
     * @return RedirectResponse
     */
    public function update( ChangeUserPasswordRequest $request ): RedirectResponse
    {
        if ( $this->user_service->changePassword( (int) $this->auth_user->id, ChangePasswordDTO::fromRequest( $request ) ) === false ) {
            return redirect()
                ->route( 'account.profile.settings.edit' )
                ->withErrors( [ 'message' => 'Не удалось изменить пароль' ] );
        }

        $contact = $this->user_service->getContactForMaster( (int) $this->auth_user->id );
        if ( $contact !== null ) {
            return redirect()->route( 'account.profile.settings.edit', [
                'contact_id' => $contact->id
            ] );
        }

        return redirect()->route( 'account.profile.settings.edit' );
    }
}

