<?php

namespace App\Http\Middleware;

use App\Enums\ProfileTypes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterRoutesForbidden
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ( $user !== null && $user->profile?->type === ProfileTypes::MASTER ) {
            abort( 403 );
        }

        return $next($request);
    }
}
