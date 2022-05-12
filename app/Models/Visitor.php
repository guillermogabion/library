<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'qr_value',
    ];

    public function borrows()
    {
        return $this->morphMany(Borrow::class, 'borrowerable');
    }

    protected $hidden = [
        'remember_token','password'
    ];

}
