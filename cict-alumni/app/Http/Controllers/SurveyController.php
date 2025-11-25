<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\Point;

class SurveyController extends Controller
{
    // Show all surveys
    public function index()
    {
        $surveys = Survey::orderBy('created_at', 'desc')->get();
        return view('alumni.surveys.index', compact('surveys'));
    }

    // Show single survey (Take Survey page - with embedded Google Form)
    public function show($surveyID)
    {
        $survey = Survey::findOrFail($surveyID);
        $alumniID = auth()->user()->alumniID;

        // Check if alumni has already completed this survey
        $alreadyCompleted = \App\Models\SurveyResponse::where('surveyID', $surveyID)
                            ->where('alumniID', $alumniID)
                            ->exists();

        return view('alumni.surveys.show', compact('survey', 'alreadyCompleted'));
    }

    // ✅ AJAX endpoint to confirm completion
    public function confirmCompletion($surveyID)
    {
        $survey = Survey::findOrFail($surveyID);
        $alumniID = auth()->user()->alumniID;

        // Prevent duplicate completions
        $already = SurveyResponse::where('surveyID', $surveyID)
                                ->where('alumniID', $alumniID)
                                ->exists();

        if ($already) {
            return response()->json([
                'status'  => 'error',
                'message' => 'You have already completed this survey. You cannot retake it.',
            ], 403);
        }

        // Save survey response
        SurveyResponse::create([
            'surveyID'     => $surveyID,
            'alumniID'     => $alumniID,
            'completed'    => true,
            'completed_at' => now(),
            'points_earned'=> $survey->points,
        ]);

        // ✅ Update or create balance
        $point = Point::firstOrCreate(
            ['alumniID' => $alumniID],
            ['total_points' => 0]
        );

        $point->increment('total_points', $survey->points);

        // ✅ Also log the transaction
        \App\Models\PointTransaction::create([
            'alumniID' => $alumniID,
            'change'   => $survey->points,
            'reason'   => "Completed survey: {$survey->title}",
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Survey completed! Points awarded.',
            'points'  => $survey->points
        ]);
    }
}
