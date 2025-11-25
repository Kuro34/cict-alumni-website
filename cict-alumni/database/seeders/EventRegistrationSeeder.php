<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventRegistration;

class EventRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        EventRegistration::create([
            'eventID' => 1,
            'alumniID' => 1,
        ]);
    }
}
