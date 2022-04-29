<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getData(){

        $students = Student::all()->count();
        $teachers = Teacher::all()->count();
        $users = (int)$students + (int)$teachers;
        return [
            'books' => Book::all()->count(),
            'borroweds' => Borrow::where('hide', 'NO')->get()->count(),
            'users' => $users,
        ];
    }
}
