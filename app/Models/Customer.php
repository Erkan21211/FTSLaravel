<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Extend the correct base class
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $table = 'customers';

    // Fields that are mass assignable
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'points',
        'password',
    ];

    // Fields to hide when serialized
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = true;
}
