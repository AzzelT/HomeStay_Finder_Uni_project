<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // ── Show profile page ─────────────────────────────────────────────────────
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // ── Update profile ────────────────────────────────────────────────────────
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    // ── Update password ───────────────────────────────────────────────────────
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    // ── My reviews page ───────────────────────────────────────────────────────
    public function reviews()
    {
        $reviews = Auth::user()
            ->reviews()
            ->with('hotel')
            ->latest()
            ->get();

        return view('profile.reviews', compact('reviews'));
    }
}