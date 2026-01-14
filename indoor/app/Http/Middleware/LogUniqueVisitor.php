<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUniqueVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admin/*')) {
            return $next($request);
        }

        $ipAddress = $request->ip();
        $today = Carbon::today();

        Visit::firstOrCreate([
            'ip_address' => $ipAddress,
            'created_at' => $today,
        ]);

        return $next($request);
    }
}
