<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);
    }

    public function dashboard()
    {
        $this->authorizeAdmin();

        $stats = [
            'users' => DB::table('users')->count(),
            'hosts' => $this->hostCount(),
            'homestays' => DB::table('hotels')->count(),
            'reviews' => DB::table('reviews')->count(),
        ];

        $averageRating = DB::table('reviews')->avg('rating');

        $recentReviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('hotels', 'hotels.id', '=', 'reviews.hotel_id')
            ->select('reviews.id', 'reviews.rating', 'reviews.comment', 'reviews.created_at',
                'users.name as user_name', 'hotels.name as hotel_name')
            ->latest('reviews.created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'averageRating', 'recentReviews'));
    }

    public function reviews()
    {
        $this->authorizeAdmin();

        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('hotels', 'hotels.id', '=', 'reviews.hotel_id')
            ->select('reviews.id', 'reviews.rating', 'reviews.comment', 'reviews.created_at',
                'users.name as user_name', 'hotels.name as hotel_name')
            ->latest('reviews.created_at')
            ->paginate(10);

        return view('admin.reviews', compact('reviews'));
    }

    public function destroyReview(int $id)
    {
        $this->authorizeAdmin();
        DB::table('reviews')->where('id', $id)->delete();
        return back()->with('success', 'Review deleted successfully.');
    }

    public function users()
    {
        $this->authorizeAdmin();
        $users = User::with('roles')->latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:user,host'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $role = Role::firstOrCreate(['name' => $data['role']]);
        $user->roles()->attach($role->id);

        return back()->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, int $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return back()->with('success', 'User updated successfully.');
    }

    public function destroyUser(int $id)
    {
        $this->authorizeAdmin();
        abort_if(auth()->id() === $id, 403, 'You cannot delete your own admin account.');
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function hosts()
    {
        $this->authorizeAdmin();
        $hosts = User::with('roles')
            ->whereHas('roles', fn ($query) => $query->whereIn('name', ['host', 'Host']))
            ->withCount('roles')
            ->latest()
            ->paginate(10);

        $users = User::whereDoesntHave('roles', fn ($query) => $query->whereIn('name', ['host', 'Host']))
            ->whereDoesntHave('roles', fn ($query) => $query->whereIn('name', ['admin', 'Admin']))
            ->orderBy('name')
            ->get();

        return view('admin.hosts', compact('hosts', 'users'));
    }

    public function assignHost(int $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $role = Role::firstOrCreate(['name' => 'host']);
        $user->roles()->syncWithoutDetaching([$role->id]);
        return back()->with('success', $user->name . ' is now a host.');
    }

    public function removeHost(int $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $role = Role::whereIn('name', ['host', 'Host'])->first();
        if ($role) {
            $user->roles()->detach($role->id);
        }
        return back()->with('success', $user->name . ' is no longer a host.');
    }

    public function homestays()
    {
        $this->authorizeAdmin();
        $homestays = DB::table('hotels')
            ->leftJoin('users', 'users.id', '=', 'hotels.user_id')
            ->leftJoin('provinces', 'provinces.id', '=', 'hotels.province_id')
            ->select('hotels.*', 'users.name as host_name', 'provinces.name as province_name')
            ->latest('hotels.created_at')
            ->paginate(10);

        return view('admin.homestays', compact('homestays'));
    }

    public function editHomestay(int $id)
    {
        $this->authorizeAdmin();
        $homestay = DB::table('hotels')->where('id', $id)->firstOrFail();
        $provinces = DB::table('provinces')->orderBy('name')->get();
        return view('admin.homestay-edit', compact('homestay', 'provinces'));
    }

    public function updateHomestay(Request $request, int $id)
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'address' => ['nullable', 'string', 'max:255'],
            'province_id' => ['required', 'exists:provinces,id'],
            'star_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        DB::table('hotels')->where('id', $id)->update([
            ...$data,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.homestays')->with('success', 'Homestay updated successfully.');
    }

    public function destroyHomestay(int $id)
    {
        $this->authorizeAdmin();
        DB::table('hotels')->where('id', $id)->delete();
        return back()->with('success', 'Homestay deleted successfully.');
    }

    private function hostCount(): int
    {
        return DB::table('role_user')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->whereIn('roles.name', ['host', 'Host'])
            ->distinct()
            ->count('role_user.user_id');
    }
}
