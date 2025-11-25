<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyResponseSeeder extends Seeder
{
    public function run()
    {
        // Get the first survey
        $survey = DB::table('surveys')->first();
        if (!$survey) {
            return;
        }

        // Example alumni IDs
        $alumni = DB::table('alumni')->pluck('alumniID')->take(3);

        foreach ($alumni as $index => $alumniID) {
            DB::table('survey_responses')->insert([
                'surveyID'     => $survey->surveyID,
                'alumniID'     => $alumniID,
                'completed'    => $index % 2 === 0, // mark some as completed
                'completed_at' => $index % 2 === 0 ? now() : null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
