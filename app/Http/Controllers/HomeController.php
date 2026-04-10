<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Attraction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $zones = Zone::withCount('attractions')->get();
        $attractions = Attraction::with('zone')->get();
        
        return view('home', compact('zones', 'attractions'));
    }

    public function show(Attraction $attraction)
    {
        $attraction->load('zone', 'approvedReviews');
        $averageRating = $attraction->averageRating();
        
        return view('attraction-detail', compact('attraction', 'averageRating'));
    }
}
