<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();

        return $teachers;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',

        ]);

        $teacher = Teacher::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),


        ]);

        return $teacher;
    }
    
    public function show($id)
    {
        $teacher = Teacher::find($id);

        return $teacher;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
        ]);

        $teacher = Teacher::find($id);

        $teacherUpdate = [
            'name'=> $request->name,
            'email'=> $request->email,
        ];

        if($request->password){
            $teacherUpdate["password"] = bcrypt($request->password);
        }

        $teacher->update($teacherUpdate);

        return "Success";
    }

    public function destroy(Teacher $teacher)
    {
        
        $teacher->delete();

        return $teacher;
    }
}
