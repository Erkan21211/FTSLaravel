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
        $availableSeats = $this->faker->numberBetween(20, 50); // Pas dit aan voor debugging
        $seatsFilled = $this->faker->numberBetween(0, $availableSeats);

//        dd([
//            'available_seats' => $availableSeats,
//            'seats_filled' => $seatsFilled,
//        ]);

        return [
            'festival_id' => Festival::factory(),
            'bus_id' => Bus::factory(),
            'available_seats' => $availableSeats,
            'seats_filled' => $seatsFilled,
            'cost_per_seat' => 20.00,
            'departure_time' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'departure_location' => $this->faker->city,
        ];
    }

    public function withLimitedSeats(): self
    {
        return $this->state(fn () => [
            'available_seats' => 10,
            'seats_filled' => 9,
        ]);
    }
}
