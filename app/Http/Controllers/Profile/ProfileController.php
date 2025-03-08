<?php

namespace App\Http\Controllers\Profile;

use App\Enums\ProfileTypes;

class ProfileController extends BaseProfileController
{
    public function index()
    {
        $data = [ 'user' => $this->auth_user ];

        // возвращаем идентификатор салона только для мастера, для отрисовки меню
        if ( $this->auth_user->profile->type === ProfileTypes::MASTER ) {
            $data[ 'contact_id' ] = $this->auth_user->profile->contacts->first()->id;
        }

        $data[ 'title' ] = 'Профиль | Личный кабинет';

        return view( 'account.profile.index', $data );
    }
}
