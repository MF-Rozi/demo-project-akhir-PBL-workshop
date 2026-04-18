<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::withCount('attractions')->paginate(10);
        return view('admin.zones.index', compact('zones'));
    }

    public function create()
    {
        return view('admin.zones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('zones', 'public');
        }

        Zone::create($validated);

        return redirect()->route('admin.zones.index')->with('success', 'Zone created successfully.');
    }

    public function edit(Zone $zone)
    {
        return view('admin.zones.edit', compact('zone'));
    }

    public function update(Request $request, Zone $zone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($zone->image) {
                Storage::disk('public')->delete($zone->image);
            }
            $validated['image'] = $request->file('image')->store('zones', 'public');
        }

        $zone->update($validated);

        return redirect()->route('admin.zones.index')->with('success', 'Zone updated successfully.');
    }

    public function destroy(Zone $zone)
    {
        // Delete image if exists
        if ($zone->image) {
            Storage::disk('public')->delete($zone->image);
        }

        $zone->delete();

        return redirect()->route('admin.zones.index')->with('success', 'Zone deleted successfully.');
    }
}
