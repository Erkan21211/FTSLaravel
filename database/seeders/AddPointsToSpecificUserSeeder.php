<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class AddPointsToSpecificUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Specifieke gebruiker-ID
        $userId = 4;

        // Hoeveelheid punten toe te voegen
        $pointsToAdd = 50;

        // Zoek de gebruiker op basis van ID
        $customer = Customer::find($userId);

        if ($customer) {
            // Voeg de punten toe
            $customer->points += $pointsToAdd;
            $customer->save();

            $this->command->info("{$pointsToAdd} punten toegevoegd aan gebruiker met ID {$userId}.");
        } else {
            $this->command->error("Gebruiker met ID {$userId} niet gevonden.");
        }
    }
}
