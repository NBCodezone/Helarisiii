<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSiteIsLive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = SiteSetting::current();
        $user = $request->user();

        if ($setting->isMaintenanceMode() && !$this->requestAllowedDuringMaintenance($request, $user)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The site is currently undergoing scheduled maintenance.',
                ], 503);
            }

            return response()->view('maintenance', [
                'setting' => $setting,
            ], 503);
        }

        return $next($request);
    }

    /**
     * Allow only essential endpoints (auth + developer area) while maintenance is active.
     */
    protected function requestAllowedDuringMaintenance(Request $request, $user = null): bool
    {
        if ($request->is('login', 'logout', 'register', 'password/*')) {
            return true;
        }

        if ($request->is('developer', 'developer/*')) {
            return $user && method_exists($user, 'isDeveloper') && $user->isDeveloper();
        }

        return false;
    }
}
