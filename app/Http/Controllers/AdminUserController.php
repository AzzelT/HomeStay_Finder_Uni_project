<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        // Get all users except admins, latest first
        $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function ban(User $user)
    {
        // Prevent banning an admin
        if ($user->role === 'admin') {
            return back()->with('error', 'You cannot ban an administrator.');
        }

        // Toggle the ban status
        $user->is_banned = !$user->is_banned;
        $user->save();

        $message = $user->is_banned ? 'User has been banned.' : 'User has been unbanned.';
        return back()->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'You cannot delete an administrator.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }
}
