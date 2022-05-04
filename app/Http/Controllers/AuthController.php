<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
            $success['id'] =  $user->id;
   
            return $success;
        } 
        else{ 
            return ['error'=>'Unauthorised'];
        } 
    }


    public function userLogin(Request $request)
    {
        

        $studentExists = Student::where('qr_value', $request->data)->exists();
        $teacherExists = Teacher::where('qr_value', $request->data)->exists();

        if($studentExists){
            $student = Student::where('qr_value',$request->data)->first();
            $success = $student;
            $success['token'] =  $student->createToken('MyApp')-> accessToken; 

            return response()->json($success, 200);

        }else if ($teacherExists){
            $teacher = Teacher::where('qr_value', $request->data)->first();
            $success = $teacher;
            $success['token'] =  $teacher->createToken('MyApp')-> accessToken; 

            return response()->json($success, 200);

        }else{

            return response()->json(['error' => ['Username and Password are Wrong.']], 200);

        }

        
    }

    public function details(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function studentLogout(Request $request)
    {
        auth()->guard('student')->logout();

        $request->user()->token()->revoke();

        return "success";
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return "success";
    }
}
