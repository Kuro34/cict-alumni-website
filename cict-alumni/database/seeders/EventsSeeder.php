<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'adminID' => 1,
            'title' => 'CICT Grand Alumni Homecoming',
            'description' => 'Reconnect with your batchmates!',
            'event_date' => '2025-10-15',
            'location' => 'CICT Auditorium',
            'banner_image' => 'homecoming_banner.jpg',
        ]);

        Event::create([
            'adminID' => 1,
            'title' => 'Tech Talk 2025',
            'description' => 'A seminar about modern web technologies.',
            'event_date' => '2025-08-20',
            'location' => 'CICT Lecture Hall',
            'banner_image' => 'tech_talk_banner.jpg',
        ]);
    }
}
