<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'posts';

    // Define the fillable properties
    protected $fillable = ['title', 'content'];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Define the relationship with the Comment model
//    public function comments()
//    {
//        return $this->hasMany(Comment::class);
//    }
}
