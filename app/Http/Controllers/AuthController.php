<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken; 
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


        $studentExists = Student::where('qr_value', $request->value)->exists();
        $teacherExists = Teacher::where('qr_value', $request->value)->exists();
        $visitorExists = Visitor::where('qr_value', $request->value)->exists();

        if($studentExists){
            $student = Student::where('qr_value',$request->value)->first();
            $success = $student;
            $tokenResult = $student->createToken('MyApp',['student']);
            $token = $tokenResult->token;
            $token->save();
            $success['user_type'] =  'student';
            $success['token'] =  $tokenResult->accessToken;

            return $success;

        }else if ($teacherExists){
            $teacher = Teacher::where('qr_value', $request->value)->first();
            $success = $teacher;
            $tokenResult = $teacher->createToken('MyApp',['teacher']);
            $token = $tokenResult->token;
            $token->save();
            $success['user_type'] =  'teacher';
            $success['token'] =  $tokenResult->accessToken; 

            return $success;

        }else if ($visitorExists){
            $visitor = Visitor::where('qr_value', $request->value)->first();
            $success = $visitor;
            $tokenResult = $visitor->createToken('MyApp',['visitor']);
            $token = $tokenResult->token;
            $token->save();
            $success['user_type'] =  'visitor';
            $success['token'] =  $tokenResult->accessToken; 

            return $success;

        }else{

            return ['error'=> 'Unknown User!'];

        }

        
    }

    public function getBorrowed(Request $request)
    {
        $user = $request->user();
      
        return $user;
    }

    public function studentLogout(Request $request)
    {
        auth()->guard('student')->logout();

        $request->user()->token()->revoke();

        return "success";
    }

    public function visitorLogout(Request $request)
    {
        auth()->guard('visitor')->logout();

        $request->user()->token()->revoke();

        return "success";
    }

    public function teacherLogout(Request $request)
    {
        auth()->guard('teacher')->logout();

        $request->user()->token()->revoke();

        return "success";
    }

    public function logout(Request $request)
    {

        auth()->guard('user')->logout();

        $request->user()->token()->revoke();


        return "success";
    }
}
