<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Display gallery images
    public function index()
    {
        $images = Gallery::latest()->paginate(12);
        return view('admin.gallery.index', compact('images'));
    }

    // Show create form
    public function create()
    {
        return view('admin.gallery.create');
    }

    // Store new image
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'caption' => $request->caption,
            'image_path' => $imagePath,
            'posted_at' => now(),
        ]);

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Image added to gallery successfully.');
    }

    // Show edit form
    public function edit($galleryID)
    {
        $image = Gallery::findOrFail($galleryID);
        return view('admin.gallery.edit', compact('image'));
    }

    // Update image
    public function update(Request $request, $galleryID)
    {
        $image = Gallery::findOrFail($galleryID);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->image_path = $request->file('image')->store('gallery', 'public');
        }

        $image->update([
            'title' => $request->title,
            'caption' => $request->caption,
        ]);

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Gallery image updated successfully.');
    }

    // Delete image
    public function destroy($galleryID)
    {
        $image = Gallery::findOrFail($galleryID);

        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()->route('admin.gallery.index')
                         ->with('success', 'Image removed from gallery.');
    }
}
