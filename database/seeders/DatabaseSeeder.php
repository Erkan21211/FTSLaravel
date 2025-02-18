<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Indien nodig foreign key checks tijdelijk uitschakelen
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            CustomerSeeder::class,
            BookingSeeder::class,
            FestivalSeeder::class,
            BusSeeder::class,
            BusPlanningSeeder::class,
            AdminSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
