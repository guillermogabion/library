<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'course', 
        'year', 
    ];

    public function borrows()
    {
        return $this->morphMany(Borrow::class, 'borrowerable');
    }
}
