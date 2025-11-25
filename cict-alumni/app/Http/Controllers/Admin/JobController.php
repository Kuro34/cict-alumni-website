<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // List all job postings
    public function index()
    {
        $jobs = JobPosting::with('admin')->latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    // Show create job form
    public function create()
    {
        return view('admin.jobs.create');
    }

    // Store new job posting
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        JobPosting::create([
            'adminID' => Auth::guard('admin')->id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posting created successfully.');
    }

    // Show edit form
    public function edit(JobPosting $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    // Update job posting
    public function update(Request $request, JobPosting $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
        ]);

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'company' => $request->company,
            'category' => $request->category,
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posting updated successfully.');
    }

    // Delete a job posting
    public function destroy(JobPosting $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')->with('success', 'Job posting deleted successfully.');
    }

    // View applications for a job
    public function applications(JobPosting $job)
    {
        $applications = JobApplication::with('alumni')->where('jobID', $job->jobID)->latest()->get();
        return view('admin.jobs.applications', compact('job', 'applications'));
    }
}
