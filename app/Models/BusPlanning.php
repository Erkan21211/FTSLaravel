<?php

namespace App\Models;


use App\Models\Bus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusPlanning extends Model
{
    /** @use HasFactory<\Database\Factories\BusPlanningFactory> */
    use HasFactory;

    protected $table = 'bus_planning';
    protected $fillable = [
        'festival_id',
        'bus_id',
        'departure_time',
        'departure_location',
        'available_seats',
        'cost_per_seat',
        'seats_filled',

    ];

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function getAvailableSeatsAttribute()
    {
        return $this->capacity - $this->seats_filled;
    }
}
