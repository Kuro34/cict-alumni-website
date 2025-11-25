<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        Notification::create([
            'alumniID' => 1,
            'type' => 'event',
            'message' => 'You have a new notification #1',
            'is_read' => false,
        ]);
    }
}
