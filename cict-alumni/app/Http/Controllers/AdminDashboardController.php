<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Event;
use App\Models\JobPosting;
use App\Models\Survey;
use App\Models\Raffle;
use App\Models\Notification;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $onlineAlumniCount = 0;

        foreach (Alumni::pluck('alumniID') as $alumniID) {
            if (Cache::has('online_alumni_' . $alumniID)) {
                $onlineAlumniCount++;
            }
        }

        return view('admin.dashboard', [
            'alumniCount' => Alumni::count(),
            'eventCount' => Event::count(),
            'jobCount' => JobPosting::count(),
            'surveyCount' => Survey::count(),
            'raffleCount' => Raffle::count(),
            'notifications' => Notification::latest()->take(5)->get(),
            'onlineAlumniCount' => $onlineAlumniCount,
        ]);
    }

    public function getOnlineCount()
    {
        $onlineAlumniCount = 0;

        foreach (Alumni::pluck('alumniID') as $alumniID) {
            if (Cache::has('online_alumni_' . $alumniID)) {
                $onlineAlumniCount++;
            }
        }

        return response()->json(['count' => $onlineAlumniCount]);
    }
}
