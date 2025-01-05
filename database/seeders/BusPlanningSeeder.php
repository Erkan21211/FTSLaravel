<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\BusPlanning;
use App\Models\Festival;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusPlanningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $festivals = Festival::all();
        $buses = Bus::all();

        foreach ($festivals as $festival) {
            foreach ($buses as $bus) {
                BusPlanning::factory()->create([
                    'festival_id' => $festival->id,
                    'bus_id' => $bus->id,
                    'available_seats' => 50,
                    'cost_per_seat' => rand(20, 100),
                    'seats_filled' => rand(0, 25),
                ]);
            }
        }
    }
}
