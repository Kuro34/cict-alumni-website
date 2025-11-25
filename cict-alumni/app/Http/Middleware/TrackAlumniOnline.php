<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackAlumniOnline
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('alumni')->check()) {
            $alumni = Auth::guard('alumni')->user();
            Cache::put('alumni-online-' . $alumni->alumniID, true, now()->addMinutes(5));
        }

        return $next($request);
    }
}
