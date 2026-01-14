<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $provider = $request->route('providerDetail');

        if ($request->user()?->hasRole(['admin', 'super admin']) || $provider->user_id == $request->user()?->id) {
            return $next($request);
        }

        if ($provider) {
            $provider->load('user');
            $user = $provider->user;
        } else {
            $service = $request->route('service');
            $user = $service ? $service->provider : null;
        }

        if ($user && ! $user->is_verified) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
