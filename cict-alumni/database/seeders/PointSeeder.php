<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Point;

class PointSeeder extends Seeder
{
    public function run(): void
    {
        Point::create([
            'alumniID' => 1,
            'total_points' => 500,
        ]);
    }
}
