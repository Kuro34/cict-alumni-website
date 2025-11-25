<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Auth;

class AdminSurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a list of all surveys (for both superadmin and staff)
     */
    public function index()
    {
        // ✅ Get all surveys, ordered by creation date, with pagination
        $surveys = Survey::with('admin')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.surveys.index', compact('surveys'));
    }

    /**
     * Show form to create a new survey
     */
    public function create()
    {
        return view('admin.surveys.create');
    }

    /**
     * Store a newly created survey
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'form_url' => 'nullable|url',           // ✅ Added form_url validation
            'expected_duration' => 'nullable|integer|min:1',
            'points' => 'nullable|integer|min:0',
            'end_date' => 'nullable|date',
        ]);
    
        $survey = new Survey();
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->form_url = $request->form_url;   // ✅ Save form_url
        $survey->expected_duration = $request->expected_duration;
        $survey->points = $request->points;
        $survey->end_date = $request->end_date;
        $survey->adminID = Auth::guard('admin')->id();
        $survey->save();
    
        return redirect()->route('admin.surveys.index')->with('success', 'Survey created successfully.');
    }

    /**
     * Show form to edit a survey
     */
    public function edit($surveyID)
    {
        $survey = Survey::findOrFail($surveyID);
        return view('admin.surveys.edit', compact('survey'));
    }

    /**
     * Update a survey
     */
    public function update(Request $request, $surveyID)
    {
        $survey = Survey::findOrFail($surveyID);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'form_url' => 'nullable|url',           // ✅ Added form_url validation
            'expected_duration' => 'nullable|integer|min:1',
            'points' => 'nullable|integer|min:0',
            'end_date' => 'nullable|date',
        ]);
    
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->form_url = $request->form_url;   // ✅ Save form_url
        $survey->expected_duration = $request->expected_duration;
        $survey->points = $request->points;
        $survey->end_date = $request->end_date;
        $survey->save();
    
        return redirect()->route('admin.surveys.index')->with('success', 'Survey updated successfully.');
    }

    /**
     * Display responses for a specific survey
     */
    public function responses($surveyID)
    {
        $survey = Survey::findOrFail($surveyID);

        $responses = SurveyResponse::with('alumni')
            ->where('surveyID', $surveyID)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.surveys.responses', compact('survey', 'responses'));
    }

    /**
     * Update Google Sheet URL for a survey
     */
    public function updateSheet(Request $request, $surveyID)
    {
        $request->validate([
            'sheet_url' => 'required|url',
        ]);

        $survey = Survey::findOrFail($surveyID);
        $survey->sheet_url = $request->sheet_url;
        $survey->save();

        return redirect()->route('admin.surveys.responses', $survey->surveyID)
            ->with('success', 'Google Sheet link updated successfully.');
    }

    /**
     * Delete a survey
     */
    public function destroy($surveyID)
    {
        $survey = Survey::findOrFail($surveyID);
        $survey->delete();

        return redirect()->route('admin.surveys.index')->with('success', 'Survey deleted successfully.');
    }
}
