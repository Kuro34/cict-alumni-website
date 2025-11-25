<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Survey;

class SurveySeeder extends Seeder
{
    public function run(): void
    {
        Survey::create([
            'adminID'     => 1, // make sure an admin with ID 1 exists
            'title'       => 'CICT Alumni Feedback Survey',
            'description' => 'Help us improve by answering this quick Google Form survey.',
            'form_url'   => 'https://docs.google.com/forms/d/e/your-form-id/viewform',
            'start_date'  => now(),
            'end_date'    => now()->addDays(30),
            'points'      => 50,
        ]);

        Survey::create([
            'adminID'     => 1,
            'title'       => 'Event Experience Survey',
            'description' => 'Share your thoughts about our last alumni event.',
            'form_url'   => 'https://docs.google.com/forms/d/e/another-form-id/viewform',
            'start_date'  => now(),
            'end_date'    => now()->addDays(15),
            'points'      => 30,
        ]);
    }
}
