<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    const Available = 1;
    const Unavailable = 2;

    protected $fillable = [
        'book_title',
        'author',
        'book_type',
        'available',
        'total',
        'status',
    ];

    public function borrows()
    {
        return $this->hasMany(
            Barrow::class, 
            'book_id'
        );
    }
}
