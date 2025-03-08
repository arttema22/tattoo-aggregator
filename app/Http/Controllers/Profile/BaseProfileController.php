<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\BasePublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseProfileController extends BasePublicController
{
    protected $auth_user;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            $this->auth_user = Auth::user();
            if ( $this->auth_user->profile === null ) {
                abort(404);
            }

            return $next( $request );
        });

        parent::__construct();
    }
}
