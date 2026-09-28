<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::where('key', 'maintenance_mode')->first();
        $isMaintenance = $setting ? (bool) $setting->value : false;

        return view('admin.settings.index', compact('isMaintenance'));
    }

    public function toggleMaintenance(Request $request)
    {
        $request->validate([
        'is_maintenance' => 'nullable|boolean'
        ]);

        // Save to database
        Setting::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => $request->is_maintenance ? '1' : '0']
        );

        return back()->with('success', 'Maintenance mode updated!');
    }
}
