<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'phone_number'=>'required',

        ]);

        $teacher = Teacher::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'phone_number'=>$request->phone_number,


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
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_number'=>'required',
            'email'=>'required|email',
        ]);

        $teacher = Teacher::find($id);

        $teacherUpdate = [
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'phone_number'=>$request->phone_number,
            'email'=> $request->email,
        ];


        $teacher->update($teacherUpdate);

        return "Success";
    }

    public function generate ($id)
    {
        $teacher = Teacher::findOrFail($id);
        $qrcode = QrCode::size(200)
                ->generate($teacher->last_name.'_'.$teacher->email);

        $img_value = $teacher->last_name.'_'.$teacher->email;

        Teacher::where('id', $id)->update([
            'qr_value' => $img_value    
        ]);

        return $qrcode;
    }

    public function destroy(Teacher $teacher)
    {
        
        $teacher->delete();

        return $teacher;
    }
}
