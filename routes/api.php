<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('/userLogin', [AuthController::class, 'userLogin']);

//Protecting Routes
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/profile', function(Request $request) {
        return Auth::user();
    });

    Route::get('admin/index',[UserController::class, 'index']);
    Route::post('admin/create',[UserController::class, 'store']);
    Route::get('admin/show/{id}',[UserController::class, 'show']);
    Route::post('admin/update/{id}',[UserController::class, 'update']);
    Route::delete('admin/delete/{admin}',[UserController::class, 'destroy']);    


    Route::get('student/index',[StudentController::class, 'index']);
    Route::post('student/create',[StudentController::class, 'store']);
    Route::get('student/show/{id}',[StudentController::class, 'show']);
    Route::post('student/update/{id}',[StudentController::class, 'update']);
    Route::get('student/generate/{id}',[StudentController::class, 'generate']);
    Route::delete('student/delete/{student}',[StudentController::class, 'destroy']);


    Route::get('teacher/index',[TeacherController::class, 'index']);
    Route::post('teacher/create',[TeacherController::class, 'store']);
    Route::get('teacher/show/{id}',[TeacherController::class, 'show']);
    Route::post('teacher/update/{id}',[TeacherController::class, 'update']);
    Route::get('teacher/generate/{id}',[TeacherController::class, 'generate']);
    Route::delete('teacher/delete/{teacher}',[TeacherController::class, 'destroy']);    


    Route::get('book/index',[BookController::class, 'index']);
    Route::post('book/create',[BookController::class, 'store']);
    Route::get('book/show/{id}',[BookController::class, 'show']);
    Route::post('book/update/{id}',[BookController::class, 'update']);
    Route::delete('book/delete/{book}',[BookController::class, 'destroy']);    


    Route::get('borrow/index',[BorrowController::class, 'index']);
    Route::get('borrow/returned',[BorrowController::class, 'returned']);
    Route::post('borrow/create',[BorrowController::class, 'store']);
    Route::get('borrow/show/{id}',[BorrowController::class, 'show']);
    Route::post('borrow/update/{id}',[BorrowController::class, 'update']);


    Route::get('dashboard/getData',[DashboardController::class, 'getData']);

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});