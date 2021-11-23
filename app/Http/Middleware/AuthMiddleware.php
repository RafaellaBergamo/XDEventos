<?php

namespace App\Http\Middleware;

use App\Http\Helpers\AuthHelper;
use Closure;

class AuthMiddleware
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
        if (!AuthHelper::checkUserLogged()) {
            return redirect()->route('logout');
        }

        return $next($request);
    }
}
