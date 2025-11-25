<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PointRedemption;

class PointRedemptionSeeder extends Seeder
{
    public function run(): void
    {
        PointRedemption::create([
            'alumniID' => 1,
            'rewardID' => 1,
            'points_used' => 250,
            'reward_description' => 'CICT Hoodie',
        ]);
    }
}
