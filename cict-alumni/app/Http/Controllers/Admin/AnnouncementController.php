<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display all announcements
     */
    public function index()
    {
        // Get all notifications (all are now announcements)
        $notifications = Notification::latest()->get();
        return view('admin.announcements.index', compact('notifications'));
    }

    /**
     * Store a new announcement
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->hasFile('image') ? $request->file('image')->store('announcements', 'public') : null;

        Notification::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Announcement created successfully!');
    }

    /**
     * Update an existing announcement
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $notif = Notification::findOrFail($id);

        $path = $notif->image_path;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('announcements', 'public');
        }

        $notif->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Announcement updated successfully!');
    }

    /**
     * Delete an announcement
     */
    public function destroy($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully!');
    }
}
