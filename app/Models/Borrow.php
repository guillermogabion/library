<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'date',
        'return_date',
        'status',
        'hide'

    ];


    public function book()
    {
        return $this->belongsTo(Book::class);
    }



    public function borrowerable()
    {
        return $this->morphTo();
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
