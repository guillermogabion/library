<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Student;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'first_name'=>'required',
            'last_name'=>'required',
            'course'=>'required',
            'year'=>'required',
            'email'=>'required|email',
            'phone_number'=>'required',

        ]);

        $student = Student::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'course'=>$request->course,
            'year'=>$request->year,
            'email'=> $request->email,
            'phone_number'=>$request->phone_number,


        ]);

        return $student;
    }

    
    public function show($id)
    {
        $student = Borrow::with('book')->where('borrowerable_type', 'App\Models\Student')->where('borrowerable_id', $id)
                ->where('hide', 'NO')->get();

        return $student;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'course'=>'required',
            'phone_number'=>'required',
            'year'=>'required',
        ]);

        $student = Student::find($id);

        $studentUpdate = [
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'course'=>$request->course,
            'year'=>$request->year,
            'phone_number'=>$request->phone_number,
        ];

      

        $student->update($studentUpdate);

        return "Success";
    }

    public function generate ($id)
    {
        $student = Student::findOrFail($id);
        $qrcode = QrCode::size(200)
                ->generate($student->last_name.'(student)'.'_'.$student->email);

        $img_value = $student->last_name.'(student)'.'_'.$student->email;

        Student::where('id', $id)->update([
            'qr_value' => $img_value    
        ]);
        return $qrcode;
    }

    public function destroy(Student $student)
    {
        
        $student->delete();

        return $student;
    }
}
