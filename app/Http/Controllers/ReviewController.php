<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // Prevent a user from reviewing the same hotel twice
        $existingReview = Review::where('user_id', Auth::id())
            ->where('hotel_id', $request->hotel_id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this hotel.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'hotel_id' => $request->hotel_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Your review has been submitted!');
    }

    public function myReviews()
    {
        // Get all reviews written by the logged-in user, with the hotel details
        $reviews = Review::where('user_id', Auth::id())
            ->with('hotel')
            ->latest()
            ->paginate(10);

        return view('reviews.my-reviews', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        // Ensure the user can only delete their OWN review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();
        return back()->with('success', 'Review deleted successfully!');
    }
}
