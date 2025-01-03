<?php

namespace Database\Seeders;

use App\Models\Festival;
use Illuminate\Database\Seeder;

class FestivalSeeder extends Seeder
{
    public function run()
    {
        Festival::factory()->count(3)->create();
    }
}
