<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return $students;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'course'=>'required',
            'year'=>'required',
            'email'=>'required|email',
            'password'=>'required',

        ]);

        $student = Student::create([
            'name'=> $request->name,
            'course'=>$request->course,
            'year'=>$request->year,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),


        ]);

        return $student;
    }

    
    public function show($id)
    {
        $student = Student::find($id);

        return $student;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'course'=>'required',
            'year'=>'required',
        ]);

        $student = Student::find($id);

        $studentUpdate = [
            'name'=> $request->name,
            'email'=> $request->email,
            'course'=>$request->course,
            'year'=>$request->year,
        ];

        if($request->password){
            $studentUpdate["password"] = bcrypt($request->password);
        }

        $student->update($studentUpdate);

        return "Success";
    }

    public function destroy(Student $student)
    {
        
        $student->delete();

        return $student;
    }
}
