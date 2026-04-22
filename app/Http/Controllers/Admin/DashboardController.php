<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Review;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'zones' => Zone::count(),
            'attractions' => Attraction::count(),
            'total_reviews' => Review::count(),
            'pending_reviews' => Review::pending()->count(),
            'approved_reviews' => Review::approved()->count(),
        ];

        $recent_reviews = Review::with([
            'reviewable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([
                    Attraction::class => ['zone'],
                    Zone::class => [],
                ]);
            },
        ])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_reviews'));
    }
}
