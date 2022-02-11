<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();

        return $admins;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',

        ]);

        $admin = Admin::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),


        ]);

        return $admin;
    }
    
    public function show($id)
    {
        $admin = Admin::find($id);

        return $admin;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
        ]);

        $admin = Admin::find($id);

        $adminUpdate = [
            'name'=> $request->name,
            'email'=> $request->email,
        ];

        if($request->password){
            $adminUpdate["password"] = bcrypt($request->password);
        }

        $admin->update($adminUpdate);

        return "Success";
    }

    public function destroy(Admin $admin)
    {
        
        $admin->delete();

        return $admin;
    }
}
