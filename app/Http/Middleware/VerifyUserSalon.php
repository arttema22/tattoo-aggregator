<?php

namespace App\Http\Middleware;

use App\Services\ContactService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyUserSalon
{
    /**
     * VerifyUserSalon constructor.
     */
    public function __construct(
        private ContactService $contact_service
    ) {}


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $contact_id = $request->route()?->parameter( 'contact_id' );
        if ( $contact_id === null ) {
            abort( 404 );
        }

        $contact = $this->contact_service->findWithProfile( $contact_id );
        if ( $contact === null || $contact->profile?->user_id !== Auth::id() ) {
            abort( 403 );
        }

        return $next($request);
    }
}
