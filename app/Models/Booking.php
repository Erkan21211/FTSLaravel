<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'festival_id',
        'bus_planning_id',
        'booking_date',
        'cost',
        'status',
        'points_earned',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function festival()
    {
        return $this->belongsTo(Festival::class);
    }

    public function bus()
    {
        return $this->busPlanning->belongsTo(Bus::class);
    }

    public function busPlanning()
    {
        return $this->belongsTo(BusPlanning::class);
    }

    protected $casts = [
        'booking_date' => 'datetime', // verzorgt: booking_date als een datetime wordt behandeld
    ];
}
