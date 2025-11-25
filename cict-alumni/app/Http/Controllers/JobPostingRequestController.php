<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPostingRequest;

class JobPostingRequestController extends Controller
{
    /**
     * Show the job posting request form
     */
    public function create()
    {
        // Adjusted to match your Blade file location
        return view('job_posting_request');
    }

    /**
     * Handle the form submission
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:50',
            'contact_person' => 'required|string|max:255',
            'company_website' => 'nullable|url|max:255',
        ]);

        // Save the job posting request
        JobPostingRequest::create($validated);

        // Redirect back with a success message
        return redirect()
            ->back()
            ->with('success', '✅ Your job posting request has been submitted successfully.');
    }
}
