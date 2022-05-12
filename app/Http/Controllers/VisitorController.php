<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Visitor;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::all();

        return $visitors;
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'phone_number'=>'required',

        ]);

        $visitor = Visitor::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'phone_number'=>$request->phone_number,


        ]);

        return $visitor;
    }

    
    public function show($id)
    {
        $visitor = Borrow::with('book')->where('borrowerable_type', 'App\Models\Visitor')->where('borrowerable_id', $id)
                ->where('hide', 'NO')->get();

        return $visitor;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
            'phone_number'=>'required',
        ]);

        $visitor = Visitor::find($id);

        $visitorUpdate = [
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'email'=> $request->email,
            'phone_number'=>$request->phone_number,
        ];

      

        $visitor->update($visitorUpdate);

        return "Success";
    }

    public function generate ($id)
    {
        $visitor = Visitor::findOrFail($id);
        $qrcode = QrCode::size(200)
                ->generate($visitor->last_name.'(visitor)'.'_'.$visitor->email);

        $img_value = $visitor->last_name.'(visitor)'.'_'.$visitor->email;

        Visitor::where('id', $id)->update([
            'qr_value' => $img_value    
        ]);
        return $qrcode;
    }

    public function destroy(Visitor $visitor)
    {
        
        $visitor->delete();

        return $visitor;
    }


}
