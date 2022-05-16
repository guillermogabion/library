<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Visitor;
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

        if($request->user_type == 'Teacher'){
            $user = Teacher::find($request->user_id);
            $exists = Borrow::where('borrowerable_type', 'App\Models\Teacher')
                    ->where('borrowerable_id', $user->id)->where('book_id', $request->id)
                    ->where('hide', 'NO')->exists();
            $borrowCount = Borrow::where('borrowerable_type', 'App\Models\Teacher')->where('borrowerable_id', $user->id)
                    ->where('hide', 'NO')->get();

        }
        elseif($request->user_type == 'Student'){
            $user = Student::find($request->user_id);
            $exists = Borrow::where('borrowerable_type', 'App\Models\Student')
                    ->where('borrowerable_id', $user->id)->where('book_id', $request->id)
                    ->where('hide', 'NO')->exists();
            $borrowCount = Borrow::where('borrowerable_type', 'App\Models\Student')->where('borrowerable_id', $user->id)
                    ->where('hide', 'NO')->get();
        }
        elseif($request->user_type == 'Visitor'){
            $user = Visitor::find($request->user_id);
            $exists = Borrow::where('borrowerable_type', 'App\Models\Visitor')
                    ->where('borrowerable_id', $user->id)->where('book_id', $request->id)
                    ->where('hide', 'NO')->exists();
            $borrowCount = Borrow::where('borrowerable_type', 'App\Models\Visitor')->where('borrowerable_id', $user->id)
                    ->where('hide', 'NO')->get();
        }

        $notAvaillable = Book::where('id', $request->id)->where('available', '0')->exists();

        if($exists){
            return "Error1";
        }
        elseif($notAvaillable){
            return "Error3";
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

                if($count == 0){
                    $book->update([
                        'status' => 2
                    ]);
                }
        
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

        if($count == 1){
            $book->update([
                'status' => 1
            ]);
        }
      

        $borrow->update($borrowUpdate);

        return "Success";
    }
}