<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Alumni;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        Alumni::create([
            'last_name' => 'Doe',
            'first_name' => 'John',
            'middle_initial' => 'A',
            'age' => 25,
            'address' => '123 Alumni St.',
            'phone_number' => '09123456789',
            'current_job' => 'Software Engineer',
            'graduation_year' => 2020,
            'degree_program' => 'BSIT',
            'email' => 'johndoe@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
