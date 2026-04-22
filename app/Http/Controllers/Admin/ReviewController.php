<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Review;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with([
            'reviewable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Attraction::class => ['zone'],
                    Zone::class => [],
                ]);
            },
        ]);

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->pending();
            } elseif ($request->status === 'approved') {
                $query->approved();
            }
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
