<?php

namespace App\Http\Middleware;

use Closure;

class DataClerkMiddleware
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
        if (auth()->user()->is_data_clerk()) {
            return $next($request);
        }

        return back()->withErrors(['permission_denied' => 'Not allowed to perform action']);
    }
}
