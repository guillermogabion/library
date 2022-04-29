<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function index()
    {
        $borrows = Borrow::with('book', 'borrowerable' )->where('hide', 'NO')->get();

        return $borrows;
    }

    public function returned()
    {
        $borrows = Borrow::with('book', 'borrowerable' )->where('hide', 'YES')->get();

        return $borrows;
    }

    public function store(Request $request)
    {
        $request->validate([
            
            'id'=>'required',
            'user_id'=>'required',
            'user_type' => 'required'
           
        ]);

        $date = Carbon::now()->toDateString();

        if($request->user_type == 'teacher'){
            $user = Teacher::find($request->user_id);
        }
        elseif($request->user_type == 'student'){
            $user = Student::find($request->user_id);
        }

        $exists = Borrow::where('borrowerable_id', $user->id)->where('book_id', $request->id)->where('hide', 'NO')->exists();
        $borrowCount = Borrow::where('borrowerable_id', $user->id)->where('hide', 'NO')->get();

        if($exists){
            return "Error1";
        }
        else{
            if(count($borrowCount) == 3){
                return "Error2";
            }
            else{

                $user->borrows()->create([
                    'book_id' => $request->id,
                    'date' => $date,
                    'hide' => 'NO'
        
                ]);
        
                $book = Book::find($request->id);
        
                $count = (int)$book->available;
                $count--;
                $book->available = $count;
                $book->save();
        
                return "Success";
            }

        }
        
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id'=>'required',
            'date'=>'required',
        ]);

        $borrow = Borrow::find($id);


        $todayDate = Carbon::now()->toDateString();
        $date = Carbon::parse($borrow->date);

        $diff = $date->diffInDays($todayDate);

        if($diff > 3){
            $status = "OVERDUE";
        }
        else{
            $status = "ON TIME";
        }
       

        $borrowUpdate = [
            'book_id' => $request->book_id,
            'date' => $request->date,
            'return_date' => $todayDate,
            'status' => $status,
            'hide' => "YES" 
        ];

        $book = Book::find($borrow->book_id);

        $count = (int)$book->available;
        $count++;
        $book->available = $count;
        $book->save();

      

        $borrow->update($borrowUpdate);

        return "Success";
    }
}