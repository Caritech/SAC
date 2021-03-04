<?php

namespace App\Http\Middleware;

use Closure;

class DeveloperAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Check login
        if (!\Auth::check()) {
            abort(404);
        }

        if (auth()->user()->email != 'support@caritech.com') {
            abort(404);
        }
        //check login id
        return $next($request);
    }
}
