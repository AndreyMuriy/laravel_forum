<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->email_verified_at) {
            return redirect('/threads')
                ->with('flash', 'You must first confirm your email address.');
        }
        return $next($request);
    }
}
