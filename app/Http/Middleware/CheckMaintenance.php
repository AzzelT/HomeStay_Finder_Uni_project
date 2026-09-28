<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenance
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if maintenance mode is ON
        $setting = Setting::where('key', 'maintenance_mode')->first();
        $isMaintenance = $setting && $setting->value == '1';

        if ($isMaintenance) {

            // 2. Allow ALL auth-related paths and routes
            $path = $request->path();
            $routeName = $request->route() ? $request->route()->getName() : '';

            $isAuthPath = $request->is('login', 'register', 'logout', 'forgot-password', 'reset-password', 'verify-email', 'password/*');
            $isAuthRoute = in_array($routeName, ['login', 'register', 'logout', 'password.request', 'password.reset', 'password.email', 'verification.notice']);

            if ($isAuthPath || $isAuthRoute) {
                return $next($request);
            }

            // 3. SPECIAL CASE: If user is NOT logged in and trying to access home page, redirect to login
            if (!auth()->check() && ($path === '/' || $routeName === 'home')) {
                return redirect()->route('login');
            }

            // 4. If user is NOT logged in, block them with maintenance page
            if (!auth()->check()) {
                return response()->view('maintenance', [], 503);
            }

            // 5. Check if user is an admin
            $isAdmin = false;

            if (isset(auth()->user()->role)) {
                $roleValue = strtolower(auth()->user()->role);
                if ($roleValue === 'admin' || $roleValue === 'administrator') {
                    $isAdmin = true;
                }
            }

            if (!$isAdmin && method_exists(auth()->user(), 'roles')) {
                $isAdmin = auth()->user()->roles()->where('name', 'admin')->exists();
            }

            // 6. If NOT an admin, block them
            if (!$isAdmin) {
                return response()->view('maintenance', [], 503);
            }
        }

        return $next($request);
    }
}
