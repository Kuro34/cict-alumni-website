<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeaturedAlumnus;
use Illuminate\Support\Facades\Storage;

class FeaturedAlumniController extends Controller
{
    // Display list of featured alumni
    public function index()
    {
        $featuredAlumni = FeaturedAlumnus::latest()->paginate(10);
        return view('admin.featured-alumni.index', compact('featuredAlumni'));
    }

    // Show create form
    public function create()
    {
        return view('admin.featured-alumni.create');
    }

    // Store new featured alumnus
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        $imagePath = $request->file('image')->store('featured-alumni', 'public');

        FeaturedAlumnus::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.featured-alumni.index')
                         ->with('success', 'Featured alumnus added successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $alumnus = FeaturedAlumnus::findOrFail($id);
        return view('admin.featured-alumni.edit', compact('alumnus'));
    }

    // Update featured alumnus
    public function update(Request $request, $id)
    {
        $alumnus = FeaturedAlumnus::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($alumnus->image_path && Storage::disk('public')->exists($alumnus->image_path)) {
                Storage::disk('public')->delete($alumnus->image_path);
            }
            $alumnus->image_path = $request->file('image')->store('featured-alumni', 'public');
        }

        $alumnus->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.featured-alumni.index')
                         ->with('success', 'Featured alumnus updated successfully.');
    }

    // Delete featured alumnus
    public function destroy($id)
    {
        $alumnus = FeaturedAlumnus::findOrFail($id);

        if ($alumnus->image_path && Storage::disk('public')->exists($alumnus->image_path)) {
            Storage::disk('public')->delete($alumnus->image_path);
        }

        $alumnus->delete();

        return redirect()->route('admin.featured-alumni.index')
                         ->with('success', 'Featured alumnus deleted successfully.');
    }
}
