<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\Event;
use App\Models\Survey;
use App\Models\JobPosting;
use App\Models\Reward;
use App\Models\Raffle;
use App\Models\EventRegistration;
use App\Models\SurveyResponse;
use App\Models\RaffleEntry;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // 1️⃣ Alumni Participation Report
    public function alumniParticipation()
    {
        $alumni = Alumni::with([
            'eventRegistrations.event',
            'surveyResponses.survey',
            'points'
        ])->get();

        // Gender counts for chart
        $genderCounts = $alumni->groupBy('gender')->map->count();

        $genderCounts = $genderCounts->mapWithKeys(function($count, $key) {
            $label = $key ?: 'Not specified';
            return [$label => $count];
        });

        $orderedLabels = ['Male', 'Female', 'Other', 'Prefer not to say', 'Not specified'];
        $sortedGenderCounts = [];
        foreach ($orderedLabels as $label) {
            if(isset($genderCounts[$label])) {
                $sortedGenderCounts[$label] = $genderCounts[$label];
            }
        }
        foreach ($genderCounts as $label => $count) {
            if(!isset($sortedGenderCounts[$label])) {
                $sortedGenderCounts[$label] = $count;
            }
        }

        return view('admin.reports.alumni_participation', [
            'alumni' => $alumni,
            'genderCounts' => $sortedGenderCounts
        ]);
    }

    // 2️⃣ Points & Redemptions Report
    public function pointsRedemptions()
    {
        $alumni = Alumni::with([
            'points',
            'rewardsRedeemed.reward',
            'raffleEntries.raffle'
        ])->get();

        return view('admin.reports.points_redemptions', compact('alumni'));
    }

    // 3️⃣ Event Report
    public function eventsReport()
    {
        $totalAlumni = Alumni::count();

        $events = DB::table('events')
            ->leftJoin('event_registrations', 'events.eventID', '=', 'event_registrations.eventID')
            ->leftJoin('admins', 'events.adminID', '=', 'admins.adminID')
            ->select(
                'events.eventID',
                'events.title',
                'events.event_date',
                'admins.name as organizer',
                DB::raw('COUNT(event_registrations.registrationID) as participants_count')
            )
            ->groupBy('events.eventID', 'events.title', 'events.event_date', 'admins.name')
            ->get()
            ->map(function ($event) use ($totalAlumni) {
                $event->participation_rate = $totalAlumni > 0
                    ? round(($event->participants_count / $totalAlumni) * 100, 2)
                    : 0;
                return $event;
            });

        return view('admin.reports.events', compact('events', 'totalAlumni'));
    }

    // 4️⃣ Survey Report
    public function surveysReport()
    {
        $totalAlumni = Alumni::count();
    
        $surveys = DB::table('surveys')
            ->leftJoin('survey_responses', function($join) {
                $join->on('surveys.surveyID', '=', 'survey_responses.surveyID')
                     ->where('survey_responses.completed', true);
            })
            ->leftJoin('admins', 'surveys.adminID', '=', 'admins.adminID')
            ->select(
                'surveys.surveyID',
                'surveys.title',
                'admins.name as organizer',
                DB::raw('COUNT(survey_responses.responseID) as responses_count')
            )
            ->groupBy('surveys.surveyID', 'surveys.title', 'admins.name')
            ->get()
            ->map(function ($survey) use ($totalAlumni) {
                $survey->participation_rate = $totalAlumni > 0
                    ? round(($survey->responses_count / $totalAlumni) * 100, 2)
                    : 0;
                return $survey;
            });
    
        return view('admin.reports.surveys', compact('surveys', 'totalAlumni'));
    }

    // 5️⃣ Job Posting Report
    public function jobsReport()
    {
        $totalAlumni = Alumni::count();

        $jobs = JobPosting::withCount('applications')->get()->map(function($job) use ($totalAlumni) {
            $job->application_rate = $totalAlumni > 0
                ? round(($job->applications_count / $totalAlumni) * 100, 2)
                : 0;
            return $job;
        });

        return view('admin.reports.jobs', compact('jobs', 'totalAlumni'));
    }

    // 6️⃣ Dashboard / Aggregate Report
    public function dashboardReport()
    {
        $totalAlumni = Alumni::count();
        $totalEvents = Event::count();
        $totalSurveys = Survey::count();
        $totalRewards = Reward::count();
        $totalRaffles = Raffle::count();

        return view('admin.reports.dashboard', compact(
            'totalAlumni',
            'totalEvents',
            'totalSurveys',
            'totalRewards',
            'totalRaffles'
        ));
    }

    // ===========================
    // CSV Export Functions
    // ===========================

    // 1️⃣ Export Alumni Participation CSV
    public function exportAlumniParticipationCSV()
    {
        $alumni = Alumni::with(['eventRegistrations', 'surveyResponses', 'points'])->get();

        $filename = "alumni_participation_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Name', 'Gender', 'Age', 'Degree Program', 'Event Count', 'Survey Count', 'Total Points'];

        $callback = function() use ($alumni, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($alumni as $al) {
                fputcsv($file, [
                    $al->first_name . ' ' . ($al->middle_initial ? $al->middle_initial.'.' : '') . ' ' . $al->last_name,
                    $al->gender ?? 'Not specified',
                    $al->age ?? '-',
                    $al->degree_program ?? '-',
                    $al->eventRegistrations->count(),
                    $al->surveyResponses->count(),
                    $al->points->sum('total_points'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 2️⃣ Export Points & Redemptions CSV
    public function exportPointsRedemptionsCSV()
    {
        $alumni = Alumni::with(['points', 'rewardsRedeemed.reward', 'raffleEntries.raffle'])->get();

        $filename = "points_redemptions_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Name', 'Total Points', 'Redeemed Rewards', 'Raffle Entries'];

        $callback = function() use ($alumni, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($alumni as $al) {
                $redeemedRewards = $al->rewardsRedeemed->pluck('reward.name')->implode(', ');
                $raffleEntries = $al->raffleEntries->pluck('raffle.title')->implode(', ');

                fputcsv($file, [
                    $al->first_name . ' ' . ($al->middle_initial ? $al->middle_initial.'.' : '') . ' ' . $al->last_name,
                    $al->points->sum('total_points'),
                    $redeemedRewards ?: '-',
                    $raffleEntries ?: '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // 3️⃣ Export Events CSV (with Participation Rate)
    public function exportEventsCSV()
    {
        $totalAlumni = Alumni::count();
    
        // Use query builder to get participant counts
        $events = DB::table('events')
            ->leftJoin('event_registrations', 'events.eventID', '=', 'event_registrations.eventID')
            ->leftJoin('admins', 'events.adminID', '=', 'admins.adminID')
            ->select(
                'events.eventID',
                'events.title',
                'events.event_date',
                'admins.name as organizer',
                DB::raw('COUNT(event_registrations.registrationID) as participants_count')
            )
            ->groupBy('events.eventID', 'events.title', 'events.event_date', 'admins.name')
            ->get();
    
        $filename = "events_report_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];
    
        $columns = ['Title', 'Date', 'Organizer', 'Participants Count', 'Participation Rate (%)'];
    
        $callback = function() use ($events, $columns, $totalAlumni) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach ($events as $event) {
                $participation_rate = $totalAlumni > 0
                    ? round(($event->participants_count / $totalAlumni) * 100, 2)
                    : 0;
    
                fputcsv($file, [
                    $event->title,
                    $event->event_date,
                    $event->organizer ?? '-',
                    $event->participants_count,
                    $participation_rate
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
    // 4️⃣ Export Surveys CSV (with Participation Rate)
    public function exportSurveysCSV()
    {
        $totalAlumni = Alumni::count();
    
        $surveys = DB::table('surveys')
            ->leftJoin('survey_responses', function($join) {
                $join->on('surveys.surveyID', '=', 'survey_responses.surveyID')
                     ->where('survey_responses.completed', true);
            })
            ->leftJoin('admins', 'surveys.adminID', '=', 'admins.adminID')
            ->select(
                'surveys.surveyID',
                'surveys.title',
                'admins.name as organizer',
                DB::raw('COUNT(survey_responses.responseID) as responses_count')
            )
            ->groupBy('surveys.surveyID', 'surveys.title', 'admins.name')
            ->get();
    
        $filename = "surveys_report_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];
    
        $columns = ['Title', 'Organizer', 'Responses Count', 'Participation Rate (%)'];
    
        $callback = function() use ($surveys, $columns, $totalAlumni) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach ($surveys as $survey) {
                $participation_rate = $totalAlumni > 0
                    ? round(($survey->responses_count / $totalAlumni) * 100, 2)
                    : 0;
    
                fputcsv($file, [
                    $survey->title,
                    $survey->organizer ?? '-',
                    $survey->responses_count,
                    $participation_rate
                ]);
            }
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    

    // 5️⃣ Export Jobs CSV
    public function exportJobsCSV()
    {
        $jobs = JobPosting::withCount('applications')->get();
        $filename = "jobs_report_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
        ];

        $columns = ['Title', 'Company', 'Application Count'];

        $callback = function() use ($jobs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($jobs as $job) {
                fputcsv($file, [
                    $job->title,
                    $job->company ?? '-',
                    $job->applications_count,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
