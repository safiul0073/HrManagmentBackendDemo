<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendenceController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AdminController::class, 'register']);
Route::post('login', [AdminController::class, 'login']);
Route::post('logout', [AdminController::class, 'logout']);

// attenedence section 
Route::post('attenedence', [AttendenceController::class, 'store']); 
Route::get('attenedence', [AttendenceController::class, 'getAll']); 

// gettin all attenedence by emploey
Route::get('employee-attend', [AttendenceController::class, 'getAllAttendByEmployee']);
Route::post('employee', [AttendenceController::class, 'update']);

Route::get("getAllTotal", [AttendenceController::class, 'total']);

// get atte by month
Route::get('get-month/{id}', [AttendenceController::class, 'getMonth']);
Route::get('emoloyee-search/', [AttendenceController::class, 'getStatus']);