<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventRegisteredMail;

class EventController extends Controller
{
    // List all events for alumni
    public function index()
    {
        // Get events ordered by event_date
        $events = Event::orderBy('event_date', 'desc')->get();

        return view('alumni.events.index', compact('events'));
    }

    // Show single event details
    public function show($eventID)
    {
        $event = Event::with('admin')->findOrFail($eventID);
        $alumni = Auth::guard('alumni')->user();
    
        // Eager-load registrations to avoid null issues
        if ($alumni) {
            $alumni->load('registrations');
        }
    
        return view('alumni.events.show', compact('event', 'alumni'));
    }

    public function register(Request $request, $eventID)
    {
        $event = Event::findOrFail($eventID);
        $alumni = Auth::guard('alumni')->user();

        // Check if already registered
        if ($alumni->registrations->contains('eventID', $eventID)) {
            return redirect()->back()->with('error', 'You are already registered for this event.');
        }

        // Register alumni
        EventRegistration::create([
            'alumniID' => $alumni->alumniID,
            'eventID' => $eventID,
        ]);

        // Send confirmation email
        Mail::to($alumni->email)->send(new EventRegisteredMail($event, $alumni));

        return redirect()->back()->with('success', 'Registration successful! A confirmation email has been sent.');
    }
}
