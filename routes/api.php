<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\StudentProgress;
use App\Http\Controllers\Mobil\LoginController;
use App\Http\Controllers\Mobil\StudentProgressController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::post('/mobil/login', [LoginController::class, 'login']);
Route::get('/mobil/progress/{user_id}', [StudentProgressController::class, 'show']);
