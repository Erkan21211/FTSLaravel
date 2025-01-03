<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run()
    {
        Booking::factory()->count(5)->create([
            'customer_id' => 1, // Specifieke klant-ID
        ]);
    }
}
