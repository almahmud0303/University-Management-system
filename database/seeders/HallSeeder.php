<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    public function run(): void
    {
        $halls = [
            [
                'name' => 'Khan Jahan Ali Hall', 
                'code' => 'KJAH', 
                'type' => 'male', 
                'capacity' => 400,
                'description' => 'Main male hall with modern facilities',
                'facilities' => ['wifi', 'cafeteria', 'library', 'gym'],
                'location' => 'Main Campus',
                'is_available' => true
            ],
            [
                'name' => 'Amar Ekushey Hall', 
                'code' => 'AEH', 
                'type' => 'male', 
                'capacity' => 350,
                'description' => 'Male hall with excellent facilities',
                'facilities' => ['wifi', 'cafeteria', 'library'],
                'location' => 'Main Campus',
                'is_available' => true
            ],
            [
                'name' => 'Lalan Shah Hall', 
                'code' => 'LSH', 
                'type' => 'male', 
                'capacity' => 300,
                'description' => 'Male hall with basic facilities',
                'facilities' => ['wifi', 'cafeteria'],
                'location' => 'Main Campus',
                'is_available' => true
            ],
            [
                'name' => 'Rokeya Hall', 
                'code' => 'RH', 
                'type' => 'female', 
                'capacity' => 250,
                'description' => 'Female hall with modern facilities',
                'facilities' => ['wifi', 'cafeteria', 'library', 'gym'],
                'location' => 'Main Campus',
                'is_available' => true
            ],
        ];

        foreach ($halls as $hall) {
            Hall::firstOrCreate(
                ['code' => $hall['code']],
                $hall
            );
        }
    }
}
