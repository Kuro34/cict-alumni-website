<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Raffle;

class RafflesSeeder extends Seeder
{
    public function run(): void
    {
        Raffle::create([
            'adminID' => 1,
            'title' => 'Homecoming Raffle Draw',
            'description' => 'Get a chance to win exciting prizes during the event.',
        ]);

        Raffle::create([
            'adminID' => 1,
            'title' => 'Survey Participation Raffle',
            'description' => 'Answer our survey and get a chance to win vouchers.',
        ]);
    }
}
