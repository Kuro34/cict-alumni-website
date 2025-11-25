<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        JobApplication::create([
            'jobID' => 1,
            'alumniID' => 1,
            'cover_letter' => 'I am interested in this position.',
            'resume_path' => 'resumes/sample.pdf',
        ]);
    }
}
