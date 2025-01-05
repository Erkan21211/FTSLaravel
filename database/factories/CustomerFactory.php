<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * Het gekoppelde model.
     */
    protected $model = Customer::class;

    /**
     * Definieer het standaard model voor testdata.
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->numerify('06########'),
            'password' => bcrypt('password'), // Standaard wachtwoord
            'points' => 0, // standaard waarde
        ];
    }
}
