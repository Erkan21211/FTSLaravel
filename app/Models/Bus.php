<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    /** @use HasFactory<\Database\Factories\BusFactory> */
    use HasFactory;

    protected $fillable = [
        'name', // Naam of identificatie van de bus
        'capacity', // Totale capaciteit van de bus
    ];

    public function busPlannings()
    {
        return $this->hasMany(BusPlanning::class);
    }
}
