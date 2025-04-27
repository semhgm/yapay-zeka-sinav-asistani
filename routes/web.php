<?php

use App\Http\Controllers\Admin\ExamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.pages.dashboard');
})->name('dashboard');

Route::get('/subjects', function () {
    return view('admin.pages.subjects');
})->name('subjects.index');

Route::get('/questions', function () {
    return view('admin.pages.questions');
})->name('questions.index');
Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('exams')->name('exams.')->group(function () {
        Route::get('/', [ExamController::class, 'index'])->name('index'); // Sınav listesi (boş bırakabiliriz şimdilik)
        Route::get('/create', [ExamController::class, 'create'])->name('create'); // Sınav oluşturma formu
        Route::post('/store', [ExamController::class, 'store'])->name('store'); // Sınav kaydetme
    });

});
