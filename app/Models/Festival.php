<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Festival extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'start_date',
        'end_date',
    ];

    public function busPlanning(): HasOne
    {
        return $this->hasOne(BusPlanning::class, 'festival_id');
    }
}
