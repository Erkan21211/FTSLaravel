<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::factory()->create([
            'id' => 1,
            'first_name' => 'Erkan',
            'last_name' => 'Aslantas',
            'email' => 'erkan@example.com',
            'password' => bcrypt('password123'),
        ]);
    }
}
