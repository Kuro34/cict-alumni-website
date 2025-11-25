<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $alumni = Auth::guard('alumni')->user();

        // Build query for all jobs
        $query = JobPosting::with('admin')->latest();

        // Apply filters if provided
        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(company) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(location) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(category) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('location')) {
            $query->where('location', $request->input('location'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $allJobs = $query->get();

        // Bookmarked jobs
        $bookmarkedJobs = $alumni->bookmarkedJobs()->with('admin')->latest()->get();

        // Unique locations for dropdown
        $allLocations = JobPosting::pluck('location')->filter()->unique()->sort()->values();

        // Unique categories for dropdown
        $categories = JobPosting::pluck('category')->filter()->unique()->sort()->values();

        // 🔹 Recommended Jobs based on alumni's current job (fuzzy match by keywords)
        $currentJob = strtolower($alumni->current_job ?? '');
        $keywords = array_filter(explode(' ', $currentJob)); // split by spaces

        $recommendedJobsQuery = JobPosting::query()->with('admin');

        if (!empty($keywords)) {
            $recommendedJobsQuery->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhereRaw('LOWER(title) LIKE ?', ["%{$word}%"])
                      ->orWhereRaw('LOWER(category) LIKE ?', ["%{$word}%"]);
                }
            });
        }

        // Exclude jobs already applied to
        $recommendedJobs = $recommendedJobsQuery
            ->whereNotIn('jobID', $alumni->jobApplications()->pluck('jobID'))
            ->latest()
            ->take(5)
            ->get();

        return view('alumni.jobs.index', compact(
            'allJobs',
            'bookmarkedJobs',
            'allLocations',
            'categories',
            'recommendedJobs'
        ));
    }

    // 🔹 AJAX: Fetch jobs for search & filters
    public function fetchJobs(Request $request)
    {
        $query = JobPosting::with('admin')->latest();

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(company) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(location) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(category) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('location')) {
            $query->where('location', $request->input('location'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $jobs = $query->get();

        return response()->json(['jobs' => $jobs]);
    }

    // Toggle bookmark
    public function toggleBookmark(JobPosting $job)
    {
        $user = auth('alumni')->user();

        if ($user->bookmarkedJobs->contains($job->jobID)) {
            $user->bookmarkedJobs()->detach($job->jobID);
            return response()->json(['status' => 'removed', 'jobID' => $job->jobID]);
        } else {
            $user->bookmarkedJobs()->attach($job->jobID);
            return response()->json([
                'status' => 'added',
                'job' => [
                    'jobID' => $job->jobID,
                    'title' => $job->title,
                    'company' => $job->company,
                    'location' => $job->location,
                    'admin_name' => $job->admin->name ?? '-'
                ]
            ]);
        }
    }

    // Show bookmarked jobs
    public function bookmarked()
    {
        $alumni = Auth::guard('alumni')->user();
        $bookmarkedJobs = $alumni->bookmarkedJobs()->with('admin')->latest()->get();

        return view('alumni.jobs.bookmarked', compact('bookmarkedJobs'));
    }

    // Show pending job applications
    public function pending()
    {
        $alumni = auth('alumni')->user();
        $pendingApplications = $alumni->jobApplications()
            ->with('job.admin')
            ->get();

        return view('alumni.jobs.pending', compact('pendingApplications'));
    }

    // Cancel application
    public function cancel(JobPosting $job)
    {
        $alumniID = auth()->guard('alumni')->id();

        $application = JobApplication::where('jobID', $job->jobID)
            ->where('alumniID', $alumniID)
            ->first();

        if ($application) {
            $application->delete();
            return back()->with('success', 'Application cancelled successfully.');
        }

        return back()->with('error', 'You have not applied for this job.');
    }

    // Show job details
    public function show(JobPosting $job)
    {
        $alumni = Auth::guard('alumni')->user();
        $alreadyApplied = JobApplication::where('jobID', $job->jobID)
            ->where('alumniID', $alumni->alumniID)
            ->exists();

        return view('alumni.jobs.show', compact('job', 'alreadyApplied'));
    }

    // Apply to a job
    public function apply(Request $request, JobPosting $job)
    {
        $alumni = Auth::guard('alumni')->user();

        $exists = JobApplication::where('jobID', $job->jobID)
            ->where('alumniID', $alumni->alumniID)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }

        $request->validate([
            'cover_letter' => 'nullable|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        JobApplication::create([
            'jobID' => $job->jobID,
            'alumniID' => $alumni->alumniID,
            'cover_letter' => $request->cover_letter,
            'resume_path' => $resumePath,
        ]);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
}
