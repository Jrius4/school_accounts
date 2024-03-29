<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Session;

class AuthUsers
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \Closure $next
    * @return mixed
    */
    public function handle($request, Closure $next)
    {
        if (false == FacadesAuth::check()) {
            return redirect()->route('view.login'); //redirect User to login page
        }

        return $next($request);
    }
}
