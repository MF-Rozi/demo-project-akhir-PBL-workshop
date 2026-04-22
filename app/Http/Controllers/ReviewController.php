<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Review;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewable_type' => ['required', 'string', Rule::in(['attraction', 'zone'])],
            'reviewable_id' => 'required|integer|min:1',
            'visitor_name' => 'required|string|max:255',
            'visitor_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $reviewableTypeMap = [
            'attraction' => Attraction::class,
            'zone' => Zone::class,
        ];

        $reviewableClass = $reviewableTypeMap[$validated['reviewable_type']];

        if (! $reviewableClass::whereKey($validated['reviewable_id'])->exists()) {
            return back()
                ->withErrors(['reviewable_id' => 'The selected review target is invalid.'])
                ->withInput();
        }

        Review::create([
            'reviewable_type' => $reviewableClass,
            'reviewable_id' => $validated['reviewable_id'],
            'visitor_name' => $validated['visitor_name'],
            'visitor_email' => $validated['visitor_email'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Thank you for your review! It will be published after admin approval.');
    }
}
