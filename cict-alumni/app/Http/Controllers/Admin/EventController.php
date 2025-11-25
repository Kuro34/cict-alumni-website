<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct() {
    $this->middleware('auth:admin');
}

    // List all events (admin)
    public function index()
    {
        $events = Event::with('admin')->orderBy('event_date', 'asc')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // Show form to create a new event
    public function create()
    {
        return view('admin.events.create');
    }

    // Store new event
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title','description','event_date','location']);
        $data['adminID'] = auth('admin')->id();

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('event-banners', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully!');
    }

    // Show form to edit an event
    public function edit($eventID)
    {
        $event = Event::findOrFail($eventID);
        return view('admin.events.edit', compact('event'));
    }

    // Update event
    public function update(Request $request, $eventID)
    {
        $event = Event::findOrFail($eventID);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title','description','event_date','location']);

        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('event-banners', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    // Delete event
    public function destroy($eventID)
    {
        $event = Event::findOrFail($eventID);

        // Delete banner image
        if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }

    // Optional: Show event details (for admin)
    public function show($eventID)
    {
        $event = Event::with('registrations.alumni')->findOrFail($eventID);
        return view('admin.events.show', compact('event'));
    }
}
