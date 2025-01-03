<?php

namespace Database\Factories;

use App\Models\Booking;
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
            'booking_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'cost' => $this->faker->randomFloat(2, 50, 500),
            'status' => $this->faker->randomElement(['afgerond', 'geannuleerd', 'actief']),
            'points_earned' => $this->faker->numberBetween(10, 100), // Voeg punten toe
        ];
    }
}
