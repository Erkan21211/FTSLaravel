<?php

namespace Database\Factories;

use App\Models\BusPlanning;
use App\Models\Bus;
use App\Models\Festival;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusPlanningFactory extends Factory
{
    protected $model = BusPlanning::class;

    public function definition(): array
    {
        return [
            'festival_id' => Festival::factory(),
            'bus_id' => Bus::factory(),
            'available_seats' => $this->faker->numberBetween(20, 50),
            'seats_filled' => $this->faker->numberBetween(0, 10),
            'cost_per_seat' => $this->faker->randomFloat(2, 20, 100),
            'departure_time' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'departure_location' => $this->faker->city,
        ];
    }
}
