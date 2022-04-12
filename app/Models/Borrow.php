<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
    ];


    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrowerable()
    {
        return $this->morphTo();
    }
}
