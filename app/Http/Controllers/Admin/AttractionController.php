<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    public function index()
    {
        $attractions = Attraction::with('zone')->paginate(15);
        return view('admin.attractions.index', compact('attractions'));
    }

    public function create()
    {
        $zones = Zone::all();
        return view('admin.attractions.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('attractions', 'public');
        }

        Attraction::create($validated);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction created successfully.');
    }

    public function edit(Attraction $attraction)
    {
        $zones = Zone::all();
        return view('admin.attractions.edit', compact('attraction', 'zones'));
    }

    public function update(Request $request, Attraction $attraction)
    {
        $validated = $request->validate([
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($attraction->image) {
                Storage::disk('public')->delete($attraction->image);
            }
            $validated['image'] = $request->file('image')->store('attractions', 'public');
        }

        $attraction->update($validated);

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction updated successfully.');
    }

    public function destroy(Attraction $attraction)
    {
        if ($attraction->image) {
            Storage::disk('public')->delete($attraction->image);
        }

        $attraction->delete();

        return redirect()->route('admin.attractions.index')->with('success', 'Attraction deleted successfully.');
    }
}
