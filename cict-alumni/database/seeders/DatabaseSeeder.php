<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    $this->call([
        AdminSeeder::class,
        AlumniSeeder::class,
        EventsSeeder::class,
        JobPostingsSeeder::class,
        RafflesSeeder::class,
        SurveySeeder::class,
        SurveyResponseSeeder::class,
        EventRegistrationSeeder::class,
        RaffleEntriesSeeder::class,
        RewardSeeder::class, // ✅ ADD THIS
        PointRedemptionSeeder::class,
        PointSeeder::class,
        MessageSeeder::class,
        NotificationSeeder::class,
        JobApplicationSeeder::class,
    ]);
}



}
