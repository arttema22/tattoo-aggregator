<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BasePublicController;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\UserService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends BasePublicController
{
    use SendsPasswordResetEmails;

    /**
     * ForgotPasswordController constructor.
     */
    public function __construct(private UserService $user_service)
    {
        parent::__construct();
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return RedirectResponse
     */
    public function sendResetLinkEmail( ForgotPasswordRequest $request ): RedirectResponse
    {
        if ( $this->user_service->isApproved( $request->get( 'email' ) ) === false ) {
            return back()->withErrors( [
                'email' => 'Данный аккаунт не является подтвержденным. Если вы являетесь владельцем данного салона, свяжитесь с нами по адресу ' . config( 'contact.email' )
            ] );
        }

        $this->broker()->sendResetLink( $request->validated() );

        return back()->with( 'status', 'Ссылка на сброс пароля отправлена на почту' );
    }
}
