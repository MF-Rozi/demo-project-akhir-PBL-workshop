<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\Attraction;
use App\Models\Review;
use Illuminate\Http\Request;

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

        $recent_reviews = Review::with('attraction')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_reviews'));
    }
}
