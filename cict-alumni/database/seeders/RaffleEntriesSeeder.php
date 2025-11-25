<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RaffleEntry;

class RaffleEntriesSeeder extends Seeder
{
    public function run(): void
    {
        RaffleEntry::create([
            'raffleID' => 1,
            'alumniID' => 1,
        ]);
    }
}
