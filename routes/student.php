<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::post('/login',[AuthController::class, 'studentLogin'])->name('studentLogin');
Route::group( ['prefix' => 'v1','middleware' => ['auth:student-api','scopes:student'] ],function(){
   // authenticated staff routes here 
    Route::get('/details',[AuthController::class, 'details']);

    Route::post('/user/logout', [AuthController::class, 'studentLogout']);

});