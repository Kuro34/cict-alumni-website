<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reward;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        Reward::create([
            'name' => 'CICT Hoodie',
            'description' => 'Exclusive alumni hoodie',
            'point_cost' => 250,
        ]);
    }
}
