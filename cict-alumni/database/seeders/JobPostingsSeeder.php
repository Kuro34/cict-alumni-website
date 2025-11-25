<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPosting;

class JobPostingsSeeder extends Seeder
{
    public function run(): void
    {
        JobPosting::create([
            'adminID' => 1,
            'title' => 'Junior Web Developer',
            'description' => 'Looking for an enthusiastic web developer to join our team.',
            'location' => 'Quezon City',
            'company' => 'Tech Solutions Inc.',
        ]);

        JobPosting::create([
            'adminID' => 1,
            'title' => 'Data Analyst',
            'description' => 'Analyze data trends and generate reports.',
            'location' => 'Makati',
            'company' => 'DataCorp Philippines',
        ]);
    }
}
