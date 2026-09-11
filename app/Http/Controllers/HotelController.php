<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Province;
use App\Models\Amenity;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // ── Home page ─────────────────────────────────────────────────────────────
    public function home()
    {
        $featuredHotels = Hotel::with(['images', 'province'])
            ->latest()
            ->take(6)
            ->get();

        return view('pages.home', compact('featuredHotels'));
    }

    // ── Search & filter page ──────────────────────────────────────────────────
    public function search(Request $request)
    {
        $provinces = Province::orderBy('name')->get();
        $amenities = Amenity::orderBy('name')->get();

        $hotels = Hotel::with(['images', 'province', 'amenities', 'reviews'])
            // Search by name
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            // Filter by province
            ->when($request->province_id, function ($query) use ($request) {
                $query->where('province_id', $request->province_id);
            })
            // Filter by min price
            ->when($request->min_price, function ($query) use ($request) {
                $query->where('price_per_night', '>=', $request->min_price);
            })
            // Filter by max price
            ->when($request->max_price, function ($query) use ($request) {
                $query->where('price_per_night', '<=', $request->max_price);
            })
            // Filter by amenities
            ->when($request->amenities, function ($query) use ($request) {
                $query->whereHas('amenities', function ($q) use ($request) {
                    $q->whereIn('amenities.id', $request->amenities);
                });
            })
            ->paginate(9);

        return view('pages.search', compact('hotels', 'provinces', 'amenities'));
    }

    // ── Hotel detail page ─────────────────────────────────────────────────────
    public function show($id)
    {
        $hotel = Hotel::with([
            'images',
            'province',
            'amenities',
            'reviews.user',
        ])->findOrFail($id);

        $averageRating = $hotel->reviews->avg('rating') ?? 0;
        $totalReviews  = $hotel->reviews->count();

        return view('pages.hotel-detail', compact('hotel', 'averageRating', 'totalReviews'));
    }
}
