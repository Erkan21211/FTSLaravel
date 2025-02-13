<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'first_name' => 'Admin',
            'last_name' => 'Aslantas',
            'email' => 'admin@example.com',
            'phone_number' => '0612345678',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);
    }
}
