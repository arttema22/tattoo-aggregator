<?php

namespace App\Http\Controllers\Auth;

use App\DTO\User\ChangePasswordDTO;
use App\Http\Controllers\BasePublicController;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends BasePublicController
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::ACCOUNT_INDEX;

    /**
     * ResetPasswordController constructor.
     */
    public function __construct(private UserService $user_service)
    {
        parent::__construct();
    }

    /**
     * @param ResetPasswordRequest $request
     * @return RedirectResponse|JsonResponse
     * @throws ValidationException
     */
    public function reset( ResetPasswordRequest $request ): JsonResponse|RedirectResponse
    {
        $response = $this->broker()->reset(
            $request->validated(),
            fn ( $user, $password ) => $this->resetPassword( $user, $password ) );

        return $response === Password::PASSWORD_RESET
            ? $this->sendResetResponse( $request, $response )
            : $this->sendResetFailedResponse( $request, $response );
    }

    /**
     * @param User $user
     * @param string $password
     */
    protected function resetPassword( $user, $password ): void
    {
        $dto = App::make( ChangePasswordDTO::class );
        $dto->password = $password;

        $this->user_service->changePassword( $user->id, $dto );

        event( new PasswordReset( $user ) );

        $this->guard()->login( $user );
    }
}
