<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class EnsureUISettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only refresh the UI settings cache if in development OR parameters are passed
        if (app()->environment('local') || $request->has('refresh_ui')) {
            Cache::forget('ui_settings');
        }
        
        return $next($request);
    }
}