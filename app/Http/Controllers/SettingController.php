<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch the current maintenance mode status (defaults to false if not set)
        $maintenanceSetting = Setting::where('key', 'maintenance_mode')->first();
        $isMaintenance = $maintenanceSetting ? (bool) $maintenanceSetting->value : false;

        return view('admin.settings.index', compact('isMaintenance'));
    }

    public function toggleMaintenance(Request $request)
    {
        $request->validate([
            'is_maintenance' => 'required|boolean'
        ]);

        // Update or create the setting in the database
        Setting::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => $request->is_maintenance]
        );

        $status = $request->is_maintenance ? 'enabled' : 'disabled';
        return back()->with('success', "Maintenance mode has been {$status}.");
    }
}
