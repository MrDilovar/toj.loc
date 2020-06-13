<?php

namespace App\Http\Middleware;

use Gate;
use Closure;

class StoreMiddleware
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
        if (Gate::denies('is_store')) return redirect(route('guest.home'));

        return $next($request);
    }
}
