<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $admins = User::all();

        return $admins;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',

        ]);

        $admin = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'isAdmin'=> true,


        ]);

        return $admin;
    }
    
    public function show($id)
    {
        $admin = User::find($id);

        return $admin;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
        ]);

        $admin = User::find($id);

        $adminUpdate = [
            'name'=> $request->name,
            'email'=> $request->email,
            'isAdmin'=>$request->isAdmin,
        ];

        if($request->password){
            $adminUpdate["password"] = bcrypt($request->password);
        }

        $admin->update($adminUpdate);

        return "Success";
    }

    public function destroy(User $admin)
    {
        
        $admin->delete();

        return $admin;
    }
}
