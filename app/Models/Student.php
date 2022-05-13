<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class Student extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guards = 'student';


    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'course', 
        'year', 
        'qr_value',
        'password',
    ];

    public function borrows()
    {
        return $this->morphMany(Borrow::class, 'borrowerable');
    }

    protected $hidden = [
        'remember_token','password'
    ];
   
}
