<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Profile\ProfileDTO;
use App\DTO\User\UserDTO;
use App\Http\Controllers\BasePublicController;
use App\Providers\RouteServiceProvider;
use App\Enums\ProfileTypes;
use App\Http\Requests\Register\RegisterRequest;
use App\Services\AlbumService;
use App\Services\UserService;
use App\Services\WorkingHoursService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Services\ContactService;
use App\Services\ProfileService;

class RegisterController extends BasePublicController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::ACCOUNT_INDEX;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private UserService $user_service,
        private ProfileService $profile_service,
        private ContactService $contact_service,
        private AlbumService $album_service,
        private WorkingHoursService $working_hours_service
    ) {
        parent::__construct();

        $this->middleware('guest');
    }

    public function register( RegisterRequest $request )
    {
        $user = $this->user_service->create( UserDTO::fromRequest( $request ) );
        if ( $user === null ) {
            return response()->json( [ 'status' => 'error' ], 400 );
        }

        $profile = $this->profile_service->create( ProfileDTO::fromRequest( $request ), $user );
        if ( $profile === null ) {
            Log::warning( 'Ошибка создания профиля при регистрации', [ 'user' => $user ] );
        } elseif ( $profile->type === ProfileTypes::MASTER ) {
            $contact = $this->contact_service->createEmpty( $profile );
            if ( $contact === null ) {
                Log::warning( 'Ошибка создания салона для мастера', [
                    'user' => $user,
                    'profile' => $profile
                ] );
            }

            if ( $this->album_service->createAlbumsForContact( $contact ) === false ) {
                Log::warning( 'Ошибка создания альбомов для салона мастера', [
                    'user' => $user,
                    'profile' => $profile,
                    'contact' => $contact
                ] );
            }

            if ( $this->working_hours_service->createWorkingHoursForContact( $contact ) === false ) {
                Log::warning( 'Ошибка создания расписания для салона', [
                    'user'    => $user,
                    'profile' => $profile,
                    'contact' => $contact
                ] );
            }
        }

        event(new Registered($user));

        $this->guard()->login( $user );
        if ( $response = $this->registered( $request, $user ) ) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse( [], 201 )
            : redirect( $this->redirectPath() );
    }
}
