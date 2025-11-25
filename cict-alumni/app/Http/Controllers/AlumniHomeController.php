<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Event;
use App\Models\Survey;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AlumniHomeController extends Controller
{
    public function index()
    {
        $alumni = Auth::guard('alumni')->user();

        if (!$alumni) {
            return redirect()->route('alumni.login');
        }

        // ✅ Track online alumni for 5 minutes (shared across all sessions)
        Cache::put('online_alumni_' . $alumni->alumniID, now(), now()->addMinutes(5));

        // ✅ Retrieve data for home page
        $announcements = Notification::latest()->get();
        $events = Event::orderBy('event_date', 'desc')->take(5)->get();
        $surveys = Survey::latest()->take(5)->get();
        $totalPoints = Point::where('alumniID', $alumni->alumniID)->value('total_points') ?? 0;

        return view('alumni.home', compact('alumni', 'announcements', 'events', 'surveys', 'totalPoints'));
    }
}
