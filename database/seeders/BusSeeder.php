<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bus::factory()->count(5)->create([
            'name' => 'Bus',
            'capacity' => 50, // Standaard capaciteit
        ]);
    }
}
