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
        // 1. Check if maintenance mode is ON in the database
        $setting = Setting::where('key', 'maintenance_mode')->first();
        $isMaintenance = $setting && $setting->value == '1';

        // 2. If maintenance is ON, check who is trying to access
        if ($isMaintenance) {
            // If user is NOT logged in, block them
            if (!auth()->check()) {
                return response()->view('maintenance', [], 503);
            }

            // Check if user is an admin (handles both column and pivot table)
            $isAdmin = false;

            // Method 1: Check if there's a 'role' column
            if (isset(auth()->user()->role)) {
                $roleValue = strtolower(auth()->user()->role);
                if ($roleValue === 'admin' || $roleValue === 'administrator') {
                    $isAdmin = true;
                }
            }

            // Method 2: Check if using pivot table (roles relationship)
            if (!$isAdmin && method_exists(auth()->user(), 'roles')) {
                $isAdmin = auth()->user()->roles()->where('name', 'admin')->exists();
            }

            // If NOT an admin, block them
            if (!$isAdmin) {
                return response()->view('maintenance', [], 503);
            }
        }

        // 3. Let them through (either maintenance is off, or they're admin)
        return $next($request);
    }
}
