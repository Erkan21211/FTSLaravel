<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\BusPlanning;
use App\Models\Customer;
use App\Models\Festival;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'festival_id' => Festival::factory(),
            'bus_planning_id' => BusPlanning::factory(),
            'booking_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'cost' => $this->faker->randomFloat(2, 20, 100),
            'status' => 'actief',
            'points_earned' => 0,
        ];
    }
}
