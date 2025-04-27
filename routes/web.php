<?php

use App\Http\Controllers\Admin\ExamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;

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



Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('exams', ExamController::class);

    Route::prefix('exams/{exam}')->name('exams.')->group(function () {
        Route::resource('subjects', SubjectController::class);

        Route::prefix('subjects/{subject}')->name('subjects.')->group(function () {
            Route::resource('questions', QuestionController::class);
        });
    });

    // BAĞIMSIZ topic yönetimi
    Route::resource('topics', \App\Http\Controllers\Admin\TopicController::class);
});

