<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    public function run(): void
    {
        $halls = [
            ['name' => 'Khan Jahan Ali Hall', 'code' => 'KJAH', 'type' => 'male', 'capacity' => 400, 'occupied' => 0],
            ['name' => 'Amar Ekushey Hall', 'code' => 'AEH', 'type' => 'male', 'capacity' => 350, 'occupied' => 0],
            ['name' => 'Lalan Shah Hall', 'code' => 'LSH', 'type' => 'male', 'capacity' => 300, 'occupied' => 0],
            ['name' => 'Rokeya Hall', 'code' => 'RH', 'type' => 'female', 'capacity' => 250, 'occupied' => 0],
        ];

        foreach ($halls as $hall) {
            Hall::create($hall);
        }
    }
}
