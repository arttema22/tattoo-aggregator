<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BasePublicController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends BasePublicController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ACCOUNT_INDEX;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except( [ 'logout', 'logoutLink' ] );
    }

    public function logoutLink()
    {
        $this->guard()->logout();

        Session::invalidate();
        Session::regenerateToken();

        if ( Auth::user() !== null ) {
            return redirect( RouteServiceProvider::ACCOUNT_INDEX )
                ->withErrors( [ 'message' => 'Не удалось выйти из аккаунта' ] );
        }

        return redirect( '/' );
    }
}
