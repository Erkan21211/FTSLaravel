<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\BusPlanning;
use App\Models\Customer;
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
        $busPlanning = BusPlanning::factory()->create();
        $customer = Customer::factory()->create();

        Booking::factory()->create([
            'bus_planning_id' => $busPlanning->id,
            'customer_id' => $customer->id,
            'festival_id' => $busPlanning->festival_id,
            'cost' => $busPlanning->cost_per_seat,
            'status' => 'actief',
        ]);
    }
}
