<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Hotel;
use App\Models\HotelImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function authorizeAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);
    }

    // =========================
    // Dashboard
    // =========================

    public function dashboard()
    {
        $this->authorizeAdmin();

        $stats = [
            'users' => DB::table('users')->count(),
            'homestays' => DB::table('hotels')->count(),
            'reviews' => DB::table('reviews')->count(),
        ];

        $averageRating = DB::table('reviews')->avg('rating');

        $recentReviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('hotels', 'hotels.id', '=', 'reviews.hotel_id')
            ->select(
                'reviews.id',
                'reviews.rating',
                'reviews.comment',
                'reviews.created_at',
                'users.name as user_name',
                'hotels.name as hotel_name'
            )
            ->latest('reviews.created_at')
            ->limit(5)
            ->get();

        return view(
            'admin.dashboard',
            compact('stats', 'averageRating', 'recentReviews')
        );
    }

    // =========================
    // Reviews
    // =========================

// Reviews
    public function reviews()
    {
        $this->authorizeAdmin();

        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('hotels', 'hotels.id', '=', 'reviews.hotel_id')
            ->select(
                'reviews.id',
                'reviews.rating',
                'reviews.comment',
                'reviews.created_at',
                'users.name as user_name',
                'hotels.name as hotel_name'
            )
            ->latest('reviews.created_at')
            ->paginate(10);

        return view('admin.reviews', compact('reviews'));
    }

    public function editReview(int $id)
    {
        $this->authorizeAdmin();

        $review = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('hotels', 'hotels.id', '=', 'reviews.hotel_id')
            ->select(
                'reviews.*',
                'users.name as user_name',
                'hotels.name as hotel_name'
            )
            ->where('reviews.id', $id)
            ->first();

        abort_if(!$review, 404);

        return view('admin.review-edit', compact('review'));
    }

    public function updateReview(Request $request, int $id)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        DB::table('reviews')
            ->where('id', $id)
            ->update([
                'rating' => $data['rating'],
                'comment' => $data['comment'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.reviews')
            ->with('success', 'Review updated successfully.');
    }

    public function destroyReview(int $id)
    {
        $this->authorizeAdmin();

        DB::table('reviews')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Review deleted successfully.');
    }

    // =========================
    // Users
    // =========================

    public function users()
    {
        $this->authorizeAdmin();

        $users = User::with('roles')
            ->latest()
            ->paginate(10);

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

        $role = Role::firstOrCreate([
            'name' => $data['role'],
        ]);

        $user->roles()->attach($role->id);

        return back()->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, int $id)
    {
        $this->authorizeAdmin();

        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ],
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

        abort_if(
            auth()->id() === $id,
            403,
            'You cannot delete your own admin account.'
        );

        User::findOrFail($id)->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    // =========================
    // Homestays
    // =========================

    public function homestays()
    {
        $this->authorizeAdmin();

        $homestays = DB::table('hotels')
            ->leftJoin('users', 'users.id', '=', 'hotels.user_id')
            ->leftJoin('provinces', 'provinces.id', '=', 'hotels.province_id')
            ->select(
                'hotels.*',
                'users.name as host_name',
                'provinces.name as province_name'
            )
            ->latest('hotels.created_at')
            ->paginate(10);

        return view('admin.homestays', compact('homestays'));
    }

    // Show Add Homestay form
    public function createHomestay()
    {
        $this->authorizeAdmin();

        $provinces = DB::table('provinces')
            ->orderBy('name')
            ->get();

        // Hosts are still needed when creating a homestay.
        $hosts = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['host', 'Host']);
        })
            ->orderBy('name')
            ->get();

        return view(
            'admin.homestay-create',
            compact('provinces', 'hosts')
        );
    }

    // Store new Homestay
    public function storeHomestay(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120'
            ],

            'description' => ['nullable', 'string'],

            'price_per_night' => [
                'required',
                'numeric',
                'min:0'
            ],

            'address' => [
                'nullable',
                'string',
                'max:255'
            ],

            'province_id' => [
                'required',
                'exists:provinces,id'
            ],

            'user_id' => [
                'required',
                'exists:users,id'
            ],

            'star_rating' => [
                'nullable',
                'integer',
                'min:1',
                'max:5'
            ],

            'website_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            'facebook_url' => [
                'nullable',
                'url',
                'max:255'
            ],

            'google_maps_url' => [
                'nullable',
                'url',
                'max:255'
            ],
        ]);

        // Create the hotel
        $hotel = Hotel::create([
            'province_id' => $data['province_id'],
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'price_per_night' => $data['price_per_night'],
            'address' => $data['address'] ?? null,
            'star_rating' => $data['star_rating'] ?? null,
            'website_url' => $data['website_url'] ?? null,
            'facebook_url' => $data['facebook_url'] ?? null,
            'google_maps_url' => $data['google_maps_url'] ?? null,
        ]);

        // Upload image
        $imagePath = $request->file('image')
            ->store('hotels', 'public');

        // Save image in existing hotel_images table
        HotelImage::create([
            'hotel_id' => $hotel->id,
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('admin.homestays')
            ->with('success', 'Homestay added successfully.');
    }

    // Edit Homestay
    public function editHomestay(int $id)
    {
        $this->authorizeAdmin();

        $homestay = DB::table('hotels')
            ->where('id', $id)
            ->firstOrFail();

        $provinces = DB::table('provinces')
            ->orderBy('name')
            ->get();

        return view(
            'admin.homestay-edit',
            compact('homestay', 'provinces')
        );
    }

    // Update Homestay
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

        DB::table('hotels')
            ->where('id', $id)
            ->update([
                ...$data,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.homestays')
            ->with('success', 'Homestay updated successfully.');
    }

    // Delete Homestay
    public function destroyHomestay(int $id)
    {
        $this->authorizeAdmin();

        DB::table('hotels')
            ->where('id', $id)
            ->delete();

        return back()->with(
            'success',
            'Homestay deleted successfully.'
        );
    }
}