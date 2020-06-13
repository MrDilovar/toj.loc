<?php

namespace App\Http\Middleware;

use Gate;
use Closure;

class AdminMiddleware
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
        if (Gate::denies('is_admin')) return redirect(route('guest.home'));

        return $next($request);
    }
}
