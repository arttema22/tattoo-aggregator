<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BasePublicController;
use App\Models\User;
use App\Notifications\SuccessRegistrationNotification;
use App\Providers\RouteServiceProvider;
use App\Services\ProfileService;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class VerificationController extends BasePublicController
{
    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::ACCOUNT_INDEX;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(private ProfileService $profile_service)
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');

        parent::__construct();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    protected function verified(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        if ( $this->profile_service->approve( $user->profile->id ) === null ) {
            Log::warning( 'Произошла ошибка при попытке изменения статуса подлинности профиля', [ 'user' => $user ] );
        }

        Notification::route( 'mail', $user->email )->notify( new SuccessRegistrationNotification() );

        return redirect($this->redirectPath())->with('verified', true);
    }
}
