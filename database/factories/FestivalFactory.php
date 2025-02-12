<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Festival>
 */
class FestivalFactory extends Factory
{
    protected $model = \App\Models\Festival::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word . ' Festival',
            'location' => $this->faker->city,
            'start_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
